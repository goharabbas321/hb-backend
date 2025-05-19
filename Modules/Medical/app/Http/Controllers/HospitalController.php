<?php

namespace Modules\Medical\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Medical\Models\Hospital;
use Modules\Medical\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hospitals = Hospital::all();
        $hospitalCount = $hospitals->count();
        $deletedHospitals = Hospital::onlyTrashed()->count();

        $page_title = 'medical::messages.hospitals.heading.index';

        return view('medical::hospitals.index', [
            'totalHospitals' => $hospitalCount,
            'deletedHospitals' => $deletedHospitals,
            'page_title' => $page_title
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::all();
        $hospitalUsers = \App\Models\User::role('hospital')->get();
        $page_title = 'medical::messages.hospitals.heading.create';

        return view('medical::hospitals.create', [
            'cities' => $cities,
            'hospitalUsers' => $hospitalUsers,
            'page_title' => $page_title
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the form inputs
        $validatedData = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'user_id' => 'nullable|exists:users,id',
            'address_en' => 'required|string|max:500',
            'address_ar' => 'required|string|max:500',
            'contact_en' => 'required|string|max:255',
            'contact_ar' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:hospitals,email',
            'website' => 'nullable|url|max:255',
            'working_hours_en' => 'required|string|max:255',
            'working_hours_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string|max:1000',
            'description_ar' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'specializations' => 'nullable|array',
            'specializations.*' => 'exists:specializations,id',
            'booking_limit' => 'nullable|array',
            'booking_limit.*' => 'numeric|min:1',
            'working_days' => 'nullable|array',
            'working_days.*' => 'array',
            'working_days.*.*' => 'string|in:' . implode(',', \Modules\Medical\Enums\Day::all()),
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
            'auto_booking' => 'nullable|boolean',
        ]);

        // Create new hospital
        $hospital = new Hospital();
        $hospital->name_en = $validatedData['name_en'];
        $hospital->name_ar = $validatedData['name_ar'];
        $hospital->city_id = $validatedData['city_id'];
        $hospital->user_id = $validatedData['user_id'] ?? null;
        $hospital->address_en = $validatedData['address_en'];
        $hospital->address_ar = $validatedData['address_ar'];
        $hospital->contact_en = $validatedData['contact_en'];
        $hospital->contact_ar = $validatedData['contact_ar'];
        $hospital->email = $validatedData['email'];
        $hospital->website = $validatedData['website'] ?? null;
        $hospital->working_hours_en = $validatedData['working_hours_en'];
        $hospital->working_hours_ar = $validatedData['working_hours_ar'];
        $hospital->description_en = $validatedData['description_en'] ?? null;
        $hospital->description_ar = $validatedData['description_ar'] ?? null;
        $hospital->auto_booking = $validatedData['auto_booking'] ?? true;

        // Handle image upload
        if ($request->hasFile('image')) {
            $filename = 'hospital_' . time() . '.' . $request->file('image')->getClientOriginalExtension();
            $path = $request->file('image')->storeAs('hospitals', $filename, 'public');
            $hospital->image = $path;
        }

        $hospital->save();

        // Attach specializations with booking_limit and working_days if provided
        if (isset($validatedData['specializations'])) {
            $specializationsData = [];
            foreach ($validatedData['specializations'] as $key => $specializationId) {
                $bookingLimit = isset($validatedData['booking_limit'][$specializationId]) ?
                    $validatedData['booking_limit'][$specializationId] : 40;

                // Use provided working days or default to all days
                $workingDays = isset($validatedData['working_days'][$specializationId]) ?
                    $validatedData['working_days'][$specializationId] : \Modules\Medical\Enums\Day::all();

                $specializationsData[$specializationId] = [
                    'booking_limit' => $bookingLimit,
                    'working_days' => json_encode($workingDays)
                ];
            }
            $hospital->specializations()->attach($specializationsData);
        }

        // Attach facilities if provided
        if (isset($validatedData['facilities'])) {
            $hospital->facilities()->attach($validatedData['facilities']);
        }

        // Log activity
        activity()
            ->performedOn($hospital)
            ->causedBy(Auth::user())
            ->withProperties(['hospital_id' => $hospital->id])
            ->log('Created hospital');

        return redirect()->route('hospitals.index')->withNotify([['success', __('messages.response.create.success')]]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Hospital $hospital)
    {
        if (Auth::user()->roles->pluck('name')[0] == 'hospital') {
            if ($hospital->user_id != Auth::user()->id) {
                abort(403, 'Unauthorized action.');
            }
        }
        $page_title = 'medical::messages.hospitals.heading.show';

        return view('medical::hospitals.show', [
            'hospital' => $hospital,
            'page_title' => $page_title
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hospital $hospital)
    {
        if (Auth::user()->roles->pluck('name')[0] == 'hospital') {
            if ($hospital->user_id != Auth::user()->id) {
                abort(403, 'Unauthorized action.');
            }
        }
        $cities = City::all();
        $hospitalUsers = \App\Models\User::role('hospital')->get();
        $page_title = 'medical::messages.hospitals.heading.edit';

        return view('medical::hospitals.edit', [
            'hospital' => $hospital,
            'cities' => $cities,
            'hospitalUsers' => $hospitalUsers,
            'page_title' => $page_title
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hospital $hospital)
    {
        // Validate the form inputs
        $validatedData = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'user_id' => 'nullable|exists:users,id',
            'address_en' => 'required|string|max:500',
            'address_ar' => 'required|string|max:500',
            'contact_en' => 'required|string|max:255',
            'contact_ar' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('hospitals')->ignore($hospital->id)],
            'website' => 'nullable|url|max:255',
            'working_hours_en' => 'required|string|max:255',
            'working_hours_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string|max:1000',
            'description_ar' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'specializations' => 'nullable|array',
            'specializations.*' => 'exists:specializations,id',
            'booking_limit' => 'nullable|array',
            'booking_limit.*' => 'numeric|min:1',
            'working_days' => 'nullable|array',
            'working_days.*' => 'array',
            'working_days.*.*' => 'string|in:' . implode(',', \Modules\Medical\Enums\Day::all()),
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
            'auto_booking' => 'nullable|boolean',
        ]);

        // Update hospital data
        $hospital->name_en = $validatedData['name_en'];
        $hospital->name_ar = $validatedData['name_ar'];
        $hospital->city_id = $validatedData['city_id'];
        $hospital->user_id = $validatedData['user_id'] ?? null;
        $hospital->address_en = $validatedData['address_en'];
        $hospital->address_ar = $validatedData['address_ar'];
        $hospital->contact_en = $validatedData['contact_en'];
        $hospital->contact_ar = $validatedData['contact_ar'];
        $hospital->email = $validatedData['email'];
        $hospital->website = $validatedData['website'] ?? null;
        $hospital->working_hours_en = $validatedData['working_hours_en'];
        $hospital->working_hours_ar = $validatedData['working_hours_ar'];
        $hospital->description_en = $validatedData['description_en'] ?? null;
        $hospital->description_ar = $validatedData['description_ar'] ?? null;
        $hospital->auto_booking = $validatedData['auto_booking'] ?? true;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($hospital->image && Storage::disk('public')->exists($hospital->image)) {
                Storage::disk('public')->delete($hospital->image);
            }

            // Save new image
            $filename = 'hospital_' . time() . '.' . $request->file('image')->getClientOriginalExtension();
            $path = $request->file('image')->storeAs('hospitals', $filename, 'public');
            $hospital->image = $path;
        }

        $hospital->save();

        // Sync specializations with booking_limit and working_days
        if (isset($validatedData['specializations'])) {
            $specializationsData = [];
            foreach ($validatedData['specializations'] as $key => $specializationId) {
                $bookingLimit = isset($validatedData['booking_limit'][$specializationId]) ?
                    $validatedData['booking_limit'][$specializationId] : 40;

                // Use provided working days or default to all days
                $workingDays = isset($validatedData['working_days'][$specializationId]) ?
                    $validatedData['working_days'][$specializationId] : \Modules\Medical\Enums\Day::all();

                $specializationsData[$specializationId] = [
                    'booking_limit' => $bookingLimit,
                    'working_days' => json_encode($workingDays)
                ];
            }
            $hospital->specializations()->sync($specializationsData);
        } else {
            $hospital->specializations()->detach();
        }

        // Sync facilities
        if (isset($validatedData['facilities'])) {
            $hospital->facilities()->sync($validatedData['facilities']);
        } else {
            $hospital->facilities()->detach();
        }

        // Log activity
        activity()
            ->performedOn($hospital)
            ->causedBy(Auth::user())
            ->withProperties(['hospital_id' => $hospital->id])
            ->log('Updated hospital');

        return redirect()->route('hospitals.index')->withNotify([['success', __('messages.response.update.success')]]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hospital $hospital)
    {
        // Log activity before deletion
        activity()
            ->performedOn($hospital)
            ->causedBy(Auth::user())
            ->withProperties(['hospital_id' => $hospital->id])
            ->log('Deleted hospital');

        $hospital->delete();

        return redirect()->back()->withNotify([['success', __('messages.response.delete.success')]]);
    }

    /**
     * Handle bulk actions on multiple hospitals
     */
    public function bulkAction(Request $request)
    {
        $ids = $request->input('ids');  // Get the array of IDs
        $action = $request->input('action');  // Get the action

        if ($action == "delete") {
            if ($ids) {
                // Perform deletion in bulk
                $hospitals = Hospital::whereIn('id', $ids)->get();

                foreach ($hospitals as $hospital) {
                    activity()
                        ->performedOn($hospital)
                        ->causedBy(Auth::user())
                        ->withProperties(['hospital_id' => $hospital->id])
                        ->log('Bulk deleted hospital');
                }

                Hospital::whereIn('id', $ids)->delete();

                return response()->json([
                    'success' => true,
                    'message' => __('messages.response.delete_selected.success'),
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => __('messages.response.delete_selected.error'),
            ], 400);
        } elseif ($action == "restore") {
            if (Auth::user()->can('restore_hospitals')) {
                if ($ids) {
                    // Perform restore in bulk
                    Hospital::whereIn('id', $ids)->restore();

                    $hospitals = Hospital::withTrashed()->whereIn('id', $ids)->get();

                    foreach ($hospitals as $hospital) {
                        activity()
                            ->performedOn($hospital)
                            ->causedBy(Auth::user())
                            ->withProperties(['hospital_id' => $hospital->id])
                            ->log('Bulk restored hospital');
                    }

                    return response()->json([
                        'success' => true,
                        'message' => __('messages.response.restore_selected.success'),
                    ]);
                }

                return response()->json([
                    'success' => false,
                    'message' => __('messages.response.restore_selected.error'),
                ], 400);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('This action is unauthorized.'),
                ], 400);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => __('messages.datatable.bulk.error'),
            ], 400);
        }
    }

    /**
     * Get data for DataTables
     */
    public function getData($id, Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'name_en',
            3 => 'name_ar',
            4 => 'city_name_ar',
            5 => 'email',
            6 => 'contact_en',
            7 => 'user_name',
            8 => 'created_at',
            9 => 'action',
        );

        $custom_columns = array(
            0 => 'record_time',
        );

        $formate_columns = array(
            'created_at' => 'date'
        );

        $search_columns = array(
            0 => 'hospitals.id',
            1 => 'hospitals.name_en',
            2 => 'hospitals.name_ar',
            3 => 'cities.name_en',
            4 => 'cities.name_ar',
            5 => 'hospitals.email',
            6 => 'users.name',
        );

        $filter_date = array(
            'startDate' => $request->input('startDate'),
            'endDate' => $request->input('endDate'),
            'created_at' => 'hospitals.created_at',
            'deleted_at' => 'hospitals.deleted_at',
        );

        $filter_columns = array(
            'hospitals.name_en' => $request->input('name'),
            'cities.id' => $request->input('city'),
            'hospitals.email' => $request->input('email'),
            'hospitals.deleted_at' => $request->input('deleted_at'),
            'hospitals.user_id' => $request->input('user'),
        );

        if (Auth::user()->roles->pluck('name')[0] == 'hospital') {
            $table_data = DB::table('hospitals')
                ->join('cities', 'hospitals.city_id', '=', 'cities.id')
                ->leftJoin('users', 'hospitals.user_id', '=', 'users.id')
                ->where('hospitals.user_id', Auth::user()->id)
                ->select('hospitals.*', 'cities.name_en as city_name_en', 'cities.name_ar as city_name_ar', 'users.name as user_name');
        } else {
            $table_data = DB::table('hospitals')
                ->join('cities', 'hospitals.city_id', '=', 'cities.id')
                ->leftJoin('users', 'hospitals.user_id', '=', 'users.id')
                ->select('hospitals.*', 'cities.name_en as city_name_en', 'cities.name_ar as city_name_ar', 'users.name as user_name');
        }



        if ($id == 'null') {
            $fix_column = null;
        } else {
            $fix_column = 'hospitals.id';
        }
        $column_value = $id;

        $action = true;
        $view_route = 'hospitals.show';
        $view_permission = 'read_hospitals';
        $edit_route = 'hospitals.edit';
        $edit_permission = 'update_hospitals';
        $delete_route = 'hospitals.destroy';
        $delete_permission = 'delete_hospitals';

        $buttons = [];

        $user = Auth::user();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');
        $draw = $request->input('draw');

        $json_data = getJsonDataTable($fix_column, $column_value, $columns, $search_columns, $table_data, $limit, $start, $order, $dir, $search, $draw, $action, $user, $view_route, $view_permission, $edit_route, $edit_permission, $delete_route, $delete_permission, $buttons, $custom_columns, $filter_columns, $filter_date, $formate_columns);

        echo json_encode($json_data);
    }
}
