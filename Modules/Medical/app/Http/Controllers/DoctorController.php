<?php

namespace Modules\Medical\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Medical\Models\Doctor;
use Modules\Medical\Models\Hospital;
use Modules\Medical\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->roles->pluck('name')[0] == 'hospital') {
            $hospital = Hospital::where('user_id', Auth::user()->id)->first();
            $doctors = Doctor::where('hospital_id', $hospital->id)->get();
            $hospitals = Hospital::where('id', $hospital->id)->get();
        } else {
            $doctors = Doctor::all();
            $hospitals = Hospital::all();
        }

        $doctorCount = $doctors->count();
        $deletedDoctors = Doctor::onlyTrashed()->count();

        $page_title = 'medical::messages.doctors.heading.index';

        return view('medical::doctors.index', [
            'totalDoctors' => $doctorCount,
            'deletedDoctors' => $deletedDoctors,
            'hospitals' => $hospitals,
            'page_title' => $page_title
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hospitals = Hospital::all();
        $specializations = Specialization::all();
        $page_title = 'medical::messages.doctors.heading.create';

        return view('medical::doctors.create', [
            'hospitals' => $hospitals,
            'specializations' => $specializations,
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
            'name_en' => 'required|string|max:255|min:3',
            'name_ar' => 'required|string|max:255|min:3',
            'hospital_id' => 'required|exists:hospitals,id',
            'specialization_id' => 'required|exists:specializations,id',
            'bio_en' => 'nullable|string|max:1000',
            'bio_ar' => 'nullable|string|max:1000',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Create new doctor
        $doctor = new Doctor();
        $doctor->name_en = $validatedData['name_en'];
        $doctor->name_ar = $validatedData['name_ar'];
        $doctor->hospital_id = $validatedData['hospital_id'];
        $doctor->specialization_id = $validatedData['specialization_id'];
        $doctor->bio_en = $validatedData['bio_en'] ?? null;
        $doctor->bio_ar = $validatedData['bio_ar'] ?? null;

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $filename = 'doctor_' . time() . '.' . $request->file('profile_picture')->getClientOriginalExtension();
            $path = $request->file('profile_picture')->storeAs('doctors', $filename, 'public');
            $doctor->profile_picture = $path;
        }

        $doctor->save();

        // Log activity
        activity()
            ->performedOn($doctor)
            ->causedBy(Auth::user())
            ->withProperties(['doctor_id' => $doctor->id])
            ->log('Created doctor');

        return redirect()->route('doctors.index')->withNotify([['success', __('messages.response.create.success')]]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        // Check if the doctors belongs to the hospital of the logged-in user
        if (Auth::user()->roles->pluck('name')[0] == 'hospital') {
            $hospital = Hospital::where('user_id', Auth::user()->id)->first();
            if ($doctor->hospital_id != $hospital->id) {
                return redirect()->route('doctors.index')->withNotify([['error', __('messages.response.create.error')]]);
            }
        }

        $page_title = 'medical::messages.doctors.heading.show';

        return view('medical::doctors.show', [
            'doctor' => $doctor,
            'page_title' => $page_title
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        // Check if the doctors belongs to the hospital of the logged-in user
        if (Auth::user()->roles->pluck('name')[0] == 'hospital') {
            $hospital = Hospital::where('user_id', Auth::user()->id)->first();
            if ($doctor->hospital_id != $hospital->id) {
                return redirect()->route('doctors.index')->withNotify([['error', __('messages.response.create.error')]]);
            }
        }
        $hospitals = Hospital::all();
        $specializations = Specialization::all();
        $page_title = 'medical::messages.doctors.heading.edit';

        return view('medical::doctors.edit', [
            'doctor' => $doctor,
            'hospitals' => $hospitals,
            'specializations' => $specializations,
            'page_title' => $page_title
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        // Validate the form inputs
        $validatedData = $request->validate([
            'name_en' => 'required|string|max:255|min:3',
            'name_ar' => 'required|string|max:255|min:3',
            'hospital_id' => 'required|exists:hospitals,id',
            'specialization_id' => 'required|exists:specializations,id',
            'bio_en' => 'nullable|string|max:1000',
            'bio_ar' => 'nullable|string|max:1000',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update doctor data
        $doctor->name_en = $validatedData['name_en'];
        $doctor->name_ar = $validatedData['name_ar'];
        $doctor->hospital_id = $validatedData['hospital_id'];
        $doctor->specialization_id = $validatedData['specialization_id'];
        $doctor->bio_en = $validatedData['bio_en'] ?? null;
        $doctor->bio_ar = $validatedData['bio_ar'] ?? null;

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old image if exists
            if ($doctor->profile_picture && Storage::disk('public')->exists($doctor->profile_picture)) {
                Storage::disk('public')->delete($doctor->profile_picture);
            }

            // Save new image
            $filename = 'doctor_' . time() . '.' . $request->file('profile_picture')->getClientOriginalExtension();
            $path = $request->file('profile_picture')->storeAs('doctors', $filename, 'public');
            $doctor->profile_picture = $path;
        }

        $doctor->save();

        // Log activity
        activity()
            ->performedOn($doctor)
            ->causedBy(Auth::user())
            ->withProperties(['doctor_id' => $doctor->id])
            ->log('Updated doctor');

        return redirect()->route('doctors.index')->withNotify([['success', __('messages.response.update.success')]]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        // Log activity before deletion
        activity()
            ->performedOn($doctor)
            ->causedBy(Auth::user())
            ->withProperties(['doctor_id' => $doctor->id])
            ->log('Deleted doctor');

        $doctor->delete();

        return redirect()->back()->withNotify([['success', __('messages.response.delete.success')]]);
    }

    /**
     * Handle bulk actions on multiple doctors
     */
    public function bulkAction(Request $request)
    {
        $ids = $request->input('ids');  // Get the array of IDs
        $action = $request->input('action');  // Get the action

        if ($action == "delete") {
            if ($ids) {
                // Perform deletion in bulk
                $doctors = Doctor::whereIn('id', $ids)->get();

                foreach ($doctors as $doctor) {
                    activity()
                        ->performedOn($doctor)
                        ->causedBy(Auth::user())
                        ->withProperties(['doctor_id' => $doctor->id])
                        ->log('Bulk deleted doctor');
                }

                Doctor::whereIn('id', $ids)->delete();

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
            $user = Auth::user();
            if ($user && $user->hasPermissionTo('restore_doctors')) {
                if ($ids) {
                    // Perform restore in bulk
                    Doctor::whereIn('id', $ids)->restore();

                    $doctors = Doctor::withTrashed()->whereIn('id', $ids)->get();

                    foreach ($doctors as $doctor) {
                        activity()
                            ->performedOn($doctor)
                            ->causedBy(Auth::user())
                            ->withProperties(['doctor_id' => $doctor->id])
                            ->log('Bulk restored doctor');
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
            4 => 'hospital_name',
            5 => 'specialization_name',
            6 => 'created_at',
            7 => 'action',
        );

        $custom_columns = array(
            0 => 'record_time',
        );

        $formate_columns = array(
            'created_at' => 'date'
        );

        $search_columns = array(
            0 => 'doctors.id',
            1 => 'doctors.name_en',
            2 => 'doctors.name_ar',
            3 => 'hospitals.name_en',
            4 => 'hospitals.name_ar',
            5 => 'specializations.name_en',
            6 => 'specializations.name_ar',
        );

        $filter_date = array(
            'startDate' => $request->input('startDate'),
            'endDate' => $request->input('endDate'),
            'created_at' => 'doctors.created_at',
            'deleted_at' => 'doctors.deleted_at',
        );

        $filter_columns = array(
            'doctors.name_en' => $request->input('name'),
            'hospitals.id' => $request->input('hospital'),
            'specializations.id' => $request->input('specialization'),
            'doctors.deleted_at' => $request->input('deleted_at'),
        );

        if (Auth::user()->roles->pluck('name')[0] == 'hospital') {
            $table_data = DB::table('doctors')
                ->join('hospitals', 'doctors.hospital_id', '=', 'hospitals.id')
                ->join('specializations', 'doctors.specialization_id', '=', 'specializations.id')
                ->where('hospitals.user_id', Auth::user()->id)
                ->select('doctors.*', 'hospitals.name_en as hospital_name', 'specializations.name_en as specialization_name');
        } else {
            $table_data = DB::table('doctors')
                ->join('hospitals', 'doctors.hospital_id', '=', 'hospitals.id')
                ->join('specializations', 'doctors.specialization_id', '=', 'specializations.id')
                ->select('doctors.*', 'hospitals.name_en as hospital_name', 'specializations.name_en as specialization_name');
        }


        if ($id == 'null') {
            $fix_column = null;
        } else {
            $fix_column = 'doctors.id';
        }
        $column_value = $id;

        $action = true;
        $view_route = 'doctors.show';
        $view_permission = 'read_doctors';
        $edit_route = 'doctors.edit';
        $edit_permission = 'update_doctors';
        $delete_route = 'doctors.destroy';
        $delete_permission = 'delete_doctors';

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
