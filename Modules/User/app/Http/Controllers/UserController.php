<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /*$user = \App\Models\User::find(1); // or however you get your user
        $token = $user->createToken('postman-token')->plainTextToken;

        return response()->json(['token' => $token]);*/

        $users = User::all();
        //$users = User::role('patient')->get();
        $userCount = $users->count();
        $verified = User::whereNotNull('email_verified_at')->get()->count();
        $notVerified = User::whereNull('email_verified_at')->get()->count();
        $userBlocked = User::where('status', 0)->get()->count();

        $page_title = 'user::messages.users.heading.index';

        return view('user::index', [
            'totalUser' => $userCount,
            'verified' => $verified,
            'notVerified' => $notVerified,
            'userBlocked' => $userBlocked,
            'page_title' => $page_title
        ]);
    }

    public function show($id)
    {
        if (Auth::user()->roles->pluck('name')[0] == 'hospital') {
            $user = User::role('patient')->where('id', $id)->first();
        } else {
            $user = User::findOrFail($id);
        }

        if (!$user) {
            return redirect()->back()->withNotify([['error', __('messages.response.create.error')]]);
        }

        $page_title = 'user::messages.users.heading.index';

        return view('user::show', [
            'user' => $user,
            'page_title' => $page_title
        ]);
    }

    public function store(Request $request)
    {
        // Validate the form inputs
        $validatedData = $request->validate([
            'username' => 'nullable|string|max:255|unique:users,username|regex:/^[a-zA-Z0-9_]+$/',
            'email' => 'nullable|email|max:255|unique:users,email',
            'password' => 'nullable|string|min:8|confirmed',
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:users,phone|regex:/^\d{11}$/',
            'country' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string',
            'gender' => 'nullable|string',
            'age' => 'nullable|string',
            'emergency_contact' => 'nullable|string',
            'language' => 'nullable|string|max:10',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'role' => 'nullable|string|exists:roles,name', // Ensure the role exists in roles table
        ]);

        // Save user to the database
        $user = new User();
        if (Auth::user()->roles->pluck('name')[0] == 'hospital') {
            $user->username = 'user_' . rand(10000, 100000) . rand(10000000, 10000000000);
            $user->email = $user->username . '@hospital.com';
            $user->password = Hash::make(11223344);
            $user->language = 'english';
            $role = 'patient';
        } else {
            $user->username = $validatedData['username'];
            $user->email = $validatedData['email'];
            $user->password = Hash::make($validatedData['password']);
            $user->language = $validatedData['language'];
            $role = $validatedData['role'];
        }

        $user->email_verified_at = now();
        $user->name = $validatedData['name'];
        $user->phone = $validatedData['phone'];
        $user->user_information = json_encode(['country' => $validatedData['country'], 'address' => $validatedData['address'] ?? null, 'city' => $validatedData['city'] ?? null, 'gender' => $validatedData['gender'] ?? null, 'age' => $validatedData['age'] ?? null, 'emergency_contact' => $validatedData['emergency_contact'] ?? null]);


        // Handle the file upload
        if ($request->hasFile('profile_image')) {
            // Generate a unique name using username and timestamp
            $filename = $validatedData['username'] . '_' . time() . '.' . $request->file('profile_image')->getClientOriginalExtension();

            // Save the file to the specified directory
            $path = $request->file('profile_image')->storeAs('profile-photos', $filename, 'public');

            // Save the file path to the database or perform other actions
            $user->profile_photo_path = 'profile-photos/' . $filename;
        }

        $user->save();

        // Assign role to the user
        $user->assignRole($role);

        return redirect()->back()->withNotify([['success', __('messages.response.create.success')]]);
    }

    public function edit($id)
    {
        if (Auth::user()->roles->pluck('name')[0] == 'hospital') {
            $user = User::role('patient')->where('id', $id)->first();
        } else {
            $user = User::findOrFail($id);
        }
        if (!$user) {
            return redirect()->back()->withNotify([['error', __('messages.response.create.error')]]);
        }

        $page_title = 'user::messages.users.heading.edit';

        return view('user::edit', [
            'user' => $user,
            'page_title' => $page_title
        ]);
    }

    public function update(Request $request, User $user)
    {
        // Validate the form inputs
        $validatedData = $request->validate([
            'username' => ['nullable', 'string', 'max:255', Rule::unique('users')->ignore($user->id), 'regex:/^[a-zA-Z0-9_]+$/'],
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'name' => 'required|string|max:255',
            'phone' => ['required', Rule::unique('users')->ignore($user->id), 'regex:/^\d{11}$/'],
            'country' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string',
            'gender' => 'nullable|string',
            'age' => 'nullable|string',
            'emergency_contact' => 'nullable|string',
            'language' => 'nullable|string|max:10',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'role' => 'nullable|string|exists:roles,name', // Ensure the role exists in roles table
        ]);

        if (Auth::user()->roles->pluck('name')[0] == 'super_admin') {
            $user->username = $validatedData['username'];
            $user->email = $validatedData['email'];
            $user->language = $validatedData['language'];
        }

        // Update user to the database

        $user->name = $validatedData['name'];
        $user->phone = $validatedData['phone'];
        $user->user_information = json_encode(['country' => $validatedData['country'], 'address' => $validatedData['address'] ?? null, 'city' => $validatedData['city'] ?? null, 'gender' => $validatedData['gender'] ?? null, 'age' => $validatedData['age'] ?? null, 'emergency_contact' => $validatedData['emergency_contact'] ?? null]);


        // Handle the file upload
        if ($request->hasFile('profile_image')) {
            // Generate a unique name using username and timestamp
            $filename = $validatedData['username'] . '_' . time() . '.' . $request->file('profile_image')->getClientOriginalExtension();

            // Save the file to the specified directory
            $path = $request->file('profile_image')->storeAs('profile-photos', $filename, 'public');

            // Save the file path to the database or perform other actions
            $user->profile_photo_path = 'profile-photos/' . $filename;
        }

        // Password Change
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->update();

        if (Auth::user()->roles->pluck('name')[0] == 'super_admin') {
            // Assign role to the user
            if ($request->role != $user->roles->pluck('name')[0]) {
                // Remove the old role
                $user->removeRole($user->getRoleNames()->first());
                // Assign new role
                $user->assignRole($validatedData['role']);
            }
        }

        return redirect()->route('users.index')->withNotify([['success', __('messages.response.update.success')]]);
    }

    public function destroy($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Revoke all roles and permissions before deleting
        //$user->syncRoles([]); // Remove all roles
        //$user->permissions()->detach(); // Remove all direct permissions

        //Current User Can not be deleted
        if (Auth::id() == $id) {
            return redirect()->back()->withNotify([['error', __('messages.datatable.bulk.error')]]);
        }

        // Delete the user
        $user->delete();

        return redirect()->back()->withNotify([['success', __('messages.response.delete.success')]]);
    }

    public function bulkAction(Request $request)
    {
        $ids = $request->input('ids');  // Get the array of IDs
        $action = $request->input('action');  // Get the action

        if ($action == "delete") {
            if ($ids) {
                // Get the current logged-in user's ID
                $currentUserId = Auth::id();

                // Filter out the logged-in user's ID from the array
                $idsToDelete = array_filter($ids, function ($id) use ($currentUserId) {
                    return $id != $currentUserId;
                });

                // Perform deletion in bulk
                User::whereIn('id', $idsToDelete)->delete();  // Delete users based on the IDs

                activity()
                    ->inLog('users') // Specify a custom log name
                    ->event('bulkDelete')
                    ->by(Auth::user()) // Specify the user who caused the activity
                    ->withProperties(['ids' => $idsToDelete]) // Additional properties
                    ->log('Deleted Bulk Users.');

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
            if (Auth::user()->can('restore_users')) {
                if ($ids) {

                    // Perform restore in bulk
                    User::whereIn('id', $ids)->restore(); // Restore users based on the IDs

                    activity()
                        ->inLog('users') // Specify a custom log name
                        ->event('bulkRestore')
                        ->by(Auth::user()) // Specify the user who caused the activity
                        ->withProperties(['ids' => $ids]) // Additional properties
                        ->log('Restored Bulk Users.');

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
        } elseif ($action == "block") {
            if ($ids) {
                // Get the current logged-in user's ID
                $currentUserId = Auth::id();

                // Filter out the logged-in user's ID from the array
                $idsToUpdate = array_filter($ids, function ($id) use ($currentUserId) {
                    return $id != $currentUserId;
                });

                // Perform blocking in bulk
                User::whereIn('id', $idsToUpdate)->update(['status' => 0, 'updated_at' => now()]); // Block users based on the IDs

                activity()
                    ->inLog('users') // Specify a custom log name
                    ->event('bulkBlock')
                    ->by(Auth::user()) // Specify the user who caused the activity
                    ->withProperties(['ids' => $idsToUpdate]) // Additional properties
                    ->log('Block Bulk Users.');

                return response()->json([
                    'success' => true,
                    'message' => __('messages.response.block_selected.success'),
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => __('messages.response.block_selected.error'),
            ], 400);
        } elseif ($action == "unblock") {
            if ($ids) {
                // Get the current logged-in user's ID
                $currentUserId = Auth::id();

                // Filter out the logged-in user's ID from the array
                $idsToUpdate = array_filter($ids, function ($id) use ($currentUserId) {
                    return $id != $currentUserId;
                });

                // Perform blocking in bulk
                User::whereIn('id', $idsToUpdate)->update(['status' => 1, 'updated_at' => now()]); // Block users based on the IDs

                activity()
                    ->inLog('users') // Specify a custom log name
                    ->event('bulkUnblock')
                    ->by(Auth::user()) // Specify the user who caused the activity
                    ->withProperties(['ids' => $idsToUpdate]) // Additional properties
                    ->log('Unblock Bulk Users.');

                return response()->json([
                    'success' => true,
                    'message' => __('messages.response.unblock_selected.success'),
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => __('messages.response.unblock_selected.error'),
            ], 400);
        } else {
            return response()->json([
                'success' => false,
                'message' => __('messages.datatable.bulk.error'),
            ], 400);
        }
    }

    public function getData($id, Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'name',
            3 => 'username',
            4 => 'email',
            5 => 'role',
            6 => 'status',
            7 => 'created_at',
            8 => 'action',
        );

        $custom_columns = array(
            0 => 'record_time',
        );

        $formate_columns = array(
            'name' => 'profile_image',
            'role' => 'badge',
            'status' => 'user_status',
            'created_at' => 'date'
        );

        $search_columns = array(
            0 => 'users.id',
            1 => 'users.name',
            2 => 'users.username',
            3 => 'users.email',
            4 => 'roles.name',
        );

        $filter_date = array(
            'startDate' => $request->input('startDate'),
            'endDate' => $request->input('endDate'),
            'created_at' => 'users.created_at',
            'deleted_at' => 'users.deleted_at',
        );

        $filter_columns = array(
            'users.name' => $request->input('name'),
            'users.username' => $request->input('username'),
            'users.email' => $request->input('email'),
            'roles.name' => $request->input('role'),
            'users.status' => $request->input('status'),
            'users.deleted_at' => $request->input('deleted_at'),
        );

        if (Auth::user()->roles->pluck('name')[0] == 'hospital') {
            $table_data = DB::table('users')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('roles.name', '=', 'patient')
                ->select('users.*', 'roles.name as role');
        } else {
            $table_data = DB::table('users')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->select('users.*', 'roles.name as role');
        }

        if ($id == 'null') {
            $fix_column = null;
        } else {
            $fix_column = 'users.id';
        }
        $column_value = $id;

        $action = true;
        $view_route = 'users.show';
        $view_permission = 'read_users';
        $edit_route = 'users.edit';
        $edit_permission = 'update_users';
        $delete_route = 'users.destroy';
        $delete_permission = 'delete_users';

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
