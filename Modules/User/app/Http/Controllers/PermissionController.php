<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;
use App\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $page_title = 'user::messages.permissions.heading.index';
        $roles = Role::all();
        $types = DB::table('permissions')->select('type')->groupBy('type')->get();
        return view('user::permissions.index', compact('page_title', 'roles', 'types'));
    }

    public function store(Request $request)
    {
        // Validate the form inputs
        $validatedData = $request->validate([
            'permissionName' => 'required|string|unique:permissions,name',
            'type' => 'required',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,name',
        ]);

        // Create the permission
        $permission = Permission::create(['name' => $validatedData['permissionName'], 'guard_name' => 'web', 'type' => $validatedData['type']]);

        if (!empty($validatedData['roles'])) {
            $permission->syncRoles($validatedData['roles']);
        }

        /*activity()
            ->inLog('permissions') // Specify a custom log name
            ->performedOn($permission) // The target object
            ->event('created')
            ->by(Auth::user()) // Specify the user who caused the activity
            ->withProperties(['old' => 'old value', 'new' => 'new value']) // Additional properties
            ->log('Created Permission.');*/


        return redirect()->back()->withNotify([['success', __('messages.response.create.success')]]);

        /*DB::beginTransaction();

        try {
            // Validate the form inputs
            $validatedData = $request->validate([
                'permissionName' => 'required|string|unique:permissions,name',
                'roles' => 'nullable|array',
                'roles.*' => 'exists:roles,name',
            ]);

            //$permission = Permission::create(['name' => $validatedData['permissionName'], 'guard_name' => 'web']);

            // Insert the permission into the database
            $permissionId = DB::table('permissions')->insertGetId([
                'name' => $validatedData['permissionName'],
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $permission = Permission::find($permissionId);

            if (!empty($validatedData['roles'])) {
                $permission->syncRoles($validatedData['roles']);
            }

            // Log the activity
            activity()
                ->causedBy(Auth::user()) // The user performing the action
                ->performedOn($permission) // The target object
                ->withProperties(['name' => 'Create Permission']) // Any additional details
                ->log('Permission updated using raw query');

            DB::commit();

            return redirect()->back()->withNotify([['success', __('messages.response.create.success')]]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withNotify([['error', $e->getMessage()]]);
        }*/
    }

    public function edit(Permission $permission)
    {
        $page_title = 'user::messages.permissions.heading.edit';
        $roles = Role::all();
        $types = DB::table('permissions')->select('type')->groupBy('type')->get();
        $assignedRoles = $permission->roles->pluck('id')->toArray();
        return view('user::permissions.edit', compact('page_title', 'permission', 'roles', 'assignedRoles', 'types'));
    }

    public function update(Request $request, Permission $permission)
    {
        // Validate the form inputs
        $validatedData = $request->validate([
            'permissionName' => 'required|string|max:255|unique:roles,name,' . $permission->id,
            'type' => 'required',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,name',
        ]);

        $permission->update(['name' => $validatedData['permissionName'], 'type' => $validatedData['type']]);
        $permission->syncRoles($validatedData['roles'] ?? []);

        return redirect()->route('permissions.index')->withNotify([['success', __('messages.response.update.success')]]);
    }

    public function destroy(Permission $permission)
    {
        try {
            // Delete the permission
            $permission->delete();

            return redirect()->back()->withNotify([['success', __('messages.response.delete.success')]]);
        } catch (\Exception $e) {
            return redirect()->route('permissions.index')->withNotify([['error', __('messages.response.delete.error')]]);
        }
    }

    public function getData($id, Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'name',
            3 => 'guard_name',
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
            1 => 'name',
            2 => 'guard_name',
        );

        $filter_date = array(
            'startDate' => $request->input('startDate'),
            'endDate' => $request->input('endDate'),
            'created_at' => 'created_at',
        );

        $filter_columns = array(
            'status' => $request->input('status'),
        );

        $table_data = DB::table('permissions');

        if ($id == 'null') {
            $fix_column = null;
        } else {
            $fix_column = 'permissions.id';
        }
        $column_value = $id;

        $action = true;
        $view_route = 'permissions.show';
        $view_permission = 'read_userss';
        $edit_route = 'permissions.edit';
        $edit_permission = 'update_permissions';
        $delete_route = 'permissions.destroy';
        $delete_permission = 'delete_permissions';

        $buttons = [];

        /*$buttons[] = [
        'user' => Auth::user(),
        'permission' => 'read_users',
        'route' => 'users.index',
        'id' => 'id',
        'btn_text' => 'Print',
        'icon' => 'ti-printer',
        'attribute' => 'target="_blank"'
        ];*/

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
