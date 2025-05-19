<?php

namespace Modules\Medical\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Modules\Medical\Models\Appointment;
use Modules\Medical\Models\Hospital;
use Modules\Medical\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Add these lines to provide data for the appointment_create partial
        if (Auth::user()->roles->pluck('name')[0] == 'hospital') {
            $appointments = Appointment::where('hospital_id', Auth::user()->id)->get();
            $hospitals = Hospital::where('user_id', Auth::user()->id)->get();
            $hospital = Hospital::where('user_id', Auth::user()->id)->first();
            $specializations = $hospital->specializations;
        } else {
            $appointments = Appointment::all();
            $hospitals = Hospital::all();
            $specializations = Specialization::all();
        }

        $appointmentCount = $appointments->count();
        $deletedAppointments = Appointment::onlyTrashed()->count();

        $patients = User::role('patient')->get();

        $page_title = 'medical::messages.appointments.heading.index';

        return view('medical::appointments.index', [
            'totalAppointments' => $appointmentCount,
            'deletedAppointments' => $deletedAppointments,
            'hospitals' => $hospitals,
            'specializations' => $specializations,
            'patients' => $patients,
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
        $patients = User::role('patient')->get();
        $page_title = 'medical::messages.appointments.heading.create';

        return view('medical::appointments.create', [
            'hospitals' => $hospitals,
            'specializations' => $specializations,
            'patients' => $patients,
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
            'hospital_id' => 'required|exists:hospitals,id',
            'specialization_id' => 'required|exists:specializations,id',
            'user_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_number' => 'required|integer',
            'status' => 'required|in:scheduled,confirmed,completed,cancelled,no_show',
            'notes' => 'nullable|string|max:1000',
            'reason' => 'nullable|string|max:255',
        ]);

        // Check if booking number is available for this hospital and date
        if (!isBookingNumberAvailable($validatedData['hospital_id'], $validatedData['appointment_date'], $validatedData['appointment_number'])) {
            return redirect()->back()->withErrors([
                'appointment_number' => __('medical::messages.appointments.validation.appointment_exists')
            ])->withInput();
        }

        // Create new appointment
        $appointment = new Appointment();
        $appointment->hospital_id = $validatedData['hospital_id'];
        $appointment->specialization_id = $validatedData['specialization_id'];
        $appointment->user_id = $validatedData['user_id'];
        $appointment->appointment_date = $validatedData['appointment_date'];
        $appointment->appointment_number = $validatedData['appointment_number'];
        $appointment->status = $validatedData['status'];
        $appointment->notes = $validatedData['notes'] ?? null;
        $appointment->reason = $validatedData['reason'] ?? null;

        $appointment->save();

        // Log activity
        activity()
            ->performedOn($appointment)
            ->causedBy(Auth::user())
            ->withProperties(['appointment_id' => $appointment->id])
            ->log('Created appointment');

        return redirect()->route('appointments.index')->withNotify([['success', __('messages.response.create.success')]]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        // Check if the appointment belongs to the hospital of the logged-in user
        $hospital = Hospital::where('user_id', Auth::user()->id)->first();
        if (Auth::user()->roles->pluck('name')[0] == 'hospital' && $appointment->hospital_id != $hospital->id) {
            return redirect()->back()->withNotify([['error', __('messages.response.create.error')]]);
        }

        $page_title = 'medical::messages.appointments.heading.show';

        return view('medical::appointments.show', [
            'appointment' => $appointment,
            'page_title' => $page_title
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        // Check if the appointment belongs to the hospital of the logged-in user
        $hospital = Hospital::where('user_id', Auth::user()->id)->first();
        if (Auth::user()->roles->pluck('name')[0] == 'hospital' && $appointment->hospital_id != $hospital->id) {
            return redirect()->back()->withNotify([['error', __('messages.response.create.error')]]);
        }

        $hospitals = Hospital::all();
        $specializations = Specialization::all();
        $patients = User::role('patient')->get();
        $page_title = 'medical::messages.appointments.heading.edit';

        return view('medical::appointments.edit', [
            'appointment' => $appointment,
            'hospitals' => $hospitals,
            'specializations' => $specializations,
            'patients' => $patients,
            'page_title' => $page_title
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        // Validate the form inputs
        $validatedData = $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'specialization_id' => 'required|exists:specializations,id',
            'user_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'appointment_number' => 'required|integer',
            'status' => 'required|in:scheduled,confirmed,completed,cancelled,no_show',
            'notes' => 'nullable|string|max:1000',
            'reason' => 'nullable|string|max:255',
        ]);

        // Check if booking number is available for this hospital and date (excluding current appointment)
        $existingAppointment = Appointment::where('hospital_id', $validatedData['hospital_id'])
            ->where('appointment_date', $validatedData['appointment_date'])
            ->where('appointment_number', $validatedData['appointment_number'])
            ->where('id', '!=', $appointment->id)
            ->exists();

        if ($existingAppointment) {
            return redirect()->back()->withErrors([
                'appointment_number' => __('medical::messages.appointments.validation.appointment_exists')
            ])->withInput();
        }

        // Update appointment
        $appointment->hospital_id = $validatedData['hospital_id'];
        $appointment->specialization_id = $validatedData['specialization_id'];
        $appointment->user_id = $validatedData['user_id'];
        $appointment->appointment_date = $validatedData['appointment_date'];
        $appointment->appointment_number = $validatedData['appointment_number'];
        $appointment->status = $validatedData['status'];
        $appointment->notes = $validatedData['notes'] ?? null;
        $appointment->reason = $validatedData['reason'] ?? null;

        $appointment->save();

        // Log activity
        activity()
            ->performedOn($appointment)
            ->causedBy(Auth::user())
            ->withProperties(['appointment_id' => $appointment->id])
            ->log('Updated appointment');

        return redirect()->route('appointments.index')->withNotify([['success', __('messages.response.update.success')]]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        // Log activity before deletion
        activity()
            ->performedOn($appointment)
            ->causedBy(Auth::user())
            ->withProperties(['appointment_id' => $appointment->id])
            ->log('Deleted appointment');

        $appointment->delete();

        return redirect()->back()->withNotify([['success', __('messages.response.delete.success')]]);
    }

    /**
     * Handle bulk actions on multiple appointments
     */
    public function bulkAction(Request $request)
    {
        $ids = $request->input('ids');  // Get the array of IDs
        $action = $request->input('action');  // Get the action

        if ($action == "delete") {
            if ($ids) {
                // Perform deletion in bulk
                $appointments = Appointment::whereIn('id', $ids)->get();

                foreach ($appointments as $appointment) {
                    activity()
                        ->performedOn($appointment)
                        ->causedBy(Auth::user())
                        ->withProperties(['appointment_id' => $appointment->id])
                        ->log('Bulk deleted appointment');
                }

                Appointment::whereIn('id', $ids)->delete();

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
            if ($user && $user->hasPermissionTo('restore_appointments')) {
                if ($ids) {
                    // Perform restore in bulk
                    Appointment::whereIn('id', $ids)->restore();

                    $appointments = Appointment::withTrashed()->whereIn('id', $ids)->get();

                    foreach ($appointments as $appointment) {
                        activity()
                            ->performedOn($appointment)
                            ->causedBy(Auth::user())
                            ->withProperties(['appointment_id' => $appointment->id])
                            ->log('Bulk restored appointment');
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
            2 => 'hospital_name',
            3 => 'specialization_name',
            4 => 'patient_name',
            5 => 'appointment_date',
            6 => 'appointment_number',
            7 => 'status',
            8 => 'created_at',
            9 => 'action',
        );

        $custom_columns = array(
            0 => 'record_time',
        );

        $formate_columns = array(
            'created_at' => 'date',
            'appointment_date' => 'date'
        );

        $search_columns = array(
            0 => 'appointments.id',
            1 => 'hospitals.name_en',
            2 => 'hospitals.name_ar',
            3 => 'specializations.name_en',
            4 => 'specializations.name_ar',
            5 => 'users.name',
            6 => 'appointments.appointment_date',
            7 => 'appointments.appointment_number',
            8 => 'appointments.status',
        );

        $filter_date = array(
            'startDate' => $request->input('startDate'),
            'endDate' => $request->input('endDate'),
            'created_at' => 'appointments.created_at',
            'deleted_at' => 'appointments.deleted_at',
        );

        $filter_columns = array(
            'hospitals.id' => $request->input('hospital'),
            'specializations.id' => $request->input('specialization'),
            'users.id' => $request->input('patient'),
            'appointments.appointment_date' => $request->input('appointment_date'),
            'appointments.status' => $request->input('status'),
            'appointments.deleted_at' => $request->input('deleted_at'),
        );

        if (Auth::user()->roles->pluck('name')[0] == 'hospital') {
            $table_data = DB::table('appointments')
                ->join('hospitals', 'appointments.hospital_id', '=', 'hospitals.id')
                ->join('specializations', 'appointments.specialization_id', '=', 'specializations.id')
                ->join('users', 'appointments.user_id', '=', 'users.id')
                ->where('hospitals.user_id', Auth::user()->id)
                ->select('appointments.*', 'hospitals.name_en as hospital_name', 'specializations.name_en as specialization_name', 'users.name as patient_name');
        } else {
            $table_data = DB::table('appointments')
                ->join('hospitals', 'appointments.hospital_id', '=', 'hospitals.id')
                ->join('specializations', 'appointments.specialization_id', '=', 'specializations.id')
                ->join('users', 'appointments.user_id', '=', 'users.id')
                ->select('appointments.*', 'hospitals.name_en as hospital_name', 'specializations.name_en as specialization_name', 'users.name as patient_name');
        }


        if ($id == 'null') {
            $fix_column = null;
        } else {
            $fix_column = 'appointments.id';
        }
        $column_value = $id;

        $action = true;
        $view_route = 'appointments.show';
        $view_permission = 'read_appointments';
        $edit_route = 'appointments.edit';
        $edit_permission = 'update_appointments';
        $delete_route = 'appointments.destroy';
        $delete_permission = 'delete_appointments';

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
