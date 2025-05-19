<?php

namespace Modules\Medical\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Medical\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::all();
        $cityCount = $cities->count();
        $deletedCities = City::onlyTrashed()->count();

        $page_title = 'medical::messages.cities.heading.index';

        return view('medical::cities.index', [
            'totalCities' => $cityCount,
            'deletedCities' => $deletedCities,
            'page_title' => $page_title
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_title = 'medical::messages.cities.heading.create';
        return view('medical::cities.create', ['page_title' => $page_title]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the form inputs
        $validatedData = $request->validate([
            'name_en' => 'required|string|max:255|min:3|unique:cities,name_en',
            'name_ar' => 'required|string|max:255|min:3|unique:cities,name_ar',
        ]);

        // Create new city
        $city = new City();
        $city->name_en = $validatedData['name_en'];
        $city->name_ar = $validatedData['name_ar'];
        $city->save();

        // Log activity
        activity()
            ->performedOn($city)
            ->causedBy(Auth::user())
            ->withProperties(['city_id' => $city->id])
            ->log('Created city');

        return redirect()->route('cities.index')->withNotify([['success', __('messages.response.create.success')]]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        $page_title = 'medical::messages.cities.heading.edit';
        return view('medical::cities.edit', [
            'city' => $city,
            'page_title' => $page_title
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        // Validate the form inputs
        $validatedData = $request->validate([
            'name_en' => ['required', 'string', 'max:255', 'min:3', Rule::unique('cities')->ignore($city->id)],
            'name_ar' => ['required', 'string', 'max:255', 'min:3', Rule::unique('cities')->ignore($city->id)],
        ]);

        // Update city data
        $city->name_en = $validatedData['name_en'];
        $city->name_ar = $validatedData['name_ar'];
        $city->save();

        // Log activity
        activity()
            ->performedOn($city)
            ->causedBy(Auth::user())
            ->withProperties(['city_id' => $city->id])
            ->log('Updated city');

        return redirect()->route('cities.index')->withNotify([['success', __('messages.response.update.success')]]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        // Log activity before deletion
        activity()
            ->performedOn($city)
            ->causedBy(Auth::user())
            ->withProperties(['city_id' => $city->id])
            ->log('Deleted city');

        $city->delete();

        return redirect()->back()->withNotify([['success', __('messages.response.delete.success')]]);
    }

    /**
     * Handle bulk actions on multiple cities
     */
    public function bulkAction(Request $request)
    {
        $ids = $request->input('ids');  // Get the array of IDs
        $action = $request->input('action');  // Get the action

        if ($action == "delete") {
            if ($ids) {
                // Perform deletion in bulk
                $cities = City::whereIn('id', $ids)->get();

                foreach ($cities as $city) {
                    activity()
                        ->performedOn($city)
                        ->causedBy(Auth::user())
                        ->withProperties(['city_id' => $city->id])
                        ->log('Bulk deleted city');
                }

                City::whereIn('id', $ids)->delete();

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
            if (Auth::user()->can('restore_cities')) {
                if ($ids) {
                    // Perform restore in bulk
                    City::whereIn('id', $ids)->restore();

                    $cities = City::withTrashed()->whereIn('id', $ids)->get();

                    foreach ($cities as $city) {
                        activity()
                            ->performedOn($city)
                            ->causedBy(Auth::user())
                            ->withProperties(['city_id' => $city->id])
                            ->log('Bulk restored city');
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
            4 => 'created_at',
            5 => 'action',
        );

        $custom_columns = array(
            0 => 'record_time',
        );

        $formate_columns = array(
            'created_at' => 'date'
        );

        $search_columns = array(
            0 => 'id',
            1 => 'name_en',
            2 => 'name_ar',
        );

        $filter_date = array(
            'startDate' => $request->input('startDate'),
            'endDate' => $request->input('endDate'),
            'created_at' => 'created_at',
            'deleted_at' => 'deleted_at',
        );

        $filter_columns = array(
            'name_en' => $request->input('name'),
            'deleted_at' => $request->input('deleted_at'),
        );

        $table_data = DB::table('cities');

        if ($id == 'null') {
            $fix_column = null;
        } else {
            $fix_column = 'id';
        }
        $column_value = $id;

        $action = true;
        $view_route = "cities.edit";
        $view_permission = "reads_cities";
        $edit_route = 'cities.edit';
        $edit_permission = 'update_cities';
        $delete_route = 'cities.destroy';
        $delete_permission = 'delete_cities';

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
