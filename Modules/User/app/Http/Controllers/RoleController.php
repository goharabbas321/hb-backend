<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $page_title = 'user::messages.roles.heading.index';
        $types = DB::table('permissions')->select('type')->groupBy('type')->get();
        return view('user::roles.index', compact('page_title', 'types'));
    }

    public function store(Request $request)
    {
        // Validate the form inputs
        $validatedData = $request->validate([
            'roleName' => 'required|string|max:255|unique:roles,name,',
            'permissions' => 'array',
            'permissions.*' => 'string',
        ]);

        // Create the role
        $role = Role::create(['name' => $request->input('roleName'), 'guard_name' => 'web']);

        // Assign permissions
        $role->syncPermissions($request->input('permissions', []));

        return redirect()->back()->withNotify([['success', __('messages.response.create.success')]]);
    }

    public function edit(Role $role)
    {
        $page_title = 'user::messages.roles.heading.edit';
        $types = DB::table('permissions')->select('type')->groupBy('type')->get();
        return view('user::roles.edit', compact('page_title', 'role', 'types'));
    }

    public function update(Request $request, Role $role)
    {
        // Validate the form inputs
        $validatedData = $request->validate([
            'roleName' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array',
            'permissions.*' => 'string',
        ]);

        // Update the role name
        $role->update(['name' => $request->input('roleName')]);

        // Update permissions
        $role->syncPermissions($request->input('permissions', []));

        return redirect()->route('roles.index')->withNotify([['success', __('messages.response.update.success')]]);
    }

    public function destroy(Role $role)
    {
        try {
            // Ensure the role is not in use or protected
            if ($role->id == 1) {
                return redirect()->route('roles.index')->withNotify([['error', __('messages.response.delete.error')]]);
            }

            if ($role->users()->count() > 0) {
                return redirect()->route('roles.index')->withNotify([['error', __('messages.response.delete.user')]]);
            }

            // Delete the role
            $role->delete();

            return redirect()->back()->withNotify([['success', __('messages.response.delete.success')]]);
        } catch (\Exception $e) {
            return redirect()->route('roles.index')->withNotify([['error', __('messages.response.delete.error')]]);
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
            'name' => 'translate',
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

        $table_data = DB::table('roles');

        if ($id == 'null') {
            $fix_column = null;
        } else {
            $fix_column = 'roles.id';
        }
        $column_value = $id;

        $action = true;
        $view_route = 'roles.show';
        $view_permission = 'read_userss';
        $edit_route = 'roles.edit';
        $edit_permission = 'update_roles';
        $delete_route = 'roles.destroy';
        $delete_permission = 'delete_roles';

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
