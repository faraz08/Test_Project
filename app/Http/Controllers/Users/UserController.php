<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RoleMiddleware;
use App\Models\Department;
use App\Models\Permission;
use App\Models\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('role');
    }

    public function index()
    {

        $user = new User();

        $user_id = Auth::id();

        $admin_user = $user->isAdmin();

        $assigned_roles = array();

        if (!$admin_user) {

            $data['getUserRoles'] = User::with('roles', 'rolesPermissions')
                ->where('users.id', $user_id)->get();

            foreach ($data['getUserRoles'][0]->roles as $roles) {
                $assigned_roles[] = $roles->slug;
            }

            $data['assigned_roles'] = $assigned_roles;
            $department = User::with('department')->where('id', $user_id)->first();
            $data['departments'] = $department->department->department_name;

        } elseif ($admin_user) {

            $data['getUserRoles'] = $user->getUserWithRoles();
            $data['departments'] = Department::all();
            $data['assigned_roles'] = array('admin');
        }


        $data['status'] = array('Active', 'Inactive', 'Blocked');

        return view('users.users_list', $data);
    }

    public function editPermissions($slug)
    {
        $user_permissions = array();
        $user = new User();
        $data['user'] = User::where('name', $slug)->first();

        $data['getUserRoles'] = User::with('roles', 'department','permissions')->where('id', $data['user']->id)->first();

//        dd($data['getUserRoles']->roles[0]->name);

        foreach ($data['getUserRoles']->permissions as $permission){

            $user_permissions[] = $permission->id;
        }

        $data['user_permissions'] = $user_permissions;

//        $data['getUserRoles'] = $user->getUserWithRoles();
        $data['all_permissions'] = Permission::all();
        $data['all_roles'] = Role::all();

        $permissons = new Permission();
        $data['all_permissions'] = $permissons->allPermissions();

        $roles = new Role();
        $data['all_roles'] = $roles->allRoles();

        $data['department_list'] = Department::departmentList();

        return view('users.edit_user_permissions', $data);
    }

    public function editUserPermissions(Request $request)
    {

        $user_name = $request->input('user');
        $role = $request->input('roles');
        $permissions_list = $request->input('permissions');

        $user_role = Role::where('slug', $role)->first();

        $role_id = $user_role->id;

        if ($role_id) {

            $destroy = DB::table('roles_permissions')->where('role_id', $role_id)->delete();

            if ($destroy == 0) {

                $user_data = User::where('name', $user_name)->first();
                $user_perm = Permission::whereIn('id', $permissions_list)->pluck('id');

                if (!DB::table('users_roles')->where('role_id', $role_id)->exists()) {

                    $user_data->roles()->attach($user_role);
                }
                if (DB::table('users_permissions')->where('permission_id', $user_perm)->exists() == true) {

                    $deleted_prem = DB::table('users_permissions')->whereIn('permission_id', $user_perm)->delete();

                    foreach ($user_perm as $permission) {

                        $user_data->permissions()->attach($permission);
                    }

                    return 'true';
                }
            }
        }
    }

    public function createRolePermissions(Request $request)
    {

        $user_id = Auth::id();

        $user_name = $request->input('user');
        $role = $request->input('roles');
        $department_id = $request->input('department_id');
        $permissions = $request->input('permissions');

        $user_role = Role::where('id', $role)->first();
        $user_data = User::where('name', $user_name)->first();
//        $user_perm = Permission::whereIn('id', $permissions)->get();

        $user_perm = Permission::query()->when($permissions, function ($query, $permissions) {
            return $query->whereIn('id', $permissions);

        })->get();

        $check_user_details = DB::table('users_roles')->where('department_id', $department_id)
            ->where('user_id', $user_data->id)->exists();


        if ($check_user_details == true) {

            $user_data->roles()->sync($user_role);
            $user_data->permissions()->sync($user_perm);

            DB::table('users_roles')->where('role_id', $role)
                ->where('user_id', $user_data->id)->update(['department_id' => $department_id]);

            $getUserRoles = User::with('roles', 'permissions')
                ->where('users.id', $user_id)->orderBy('created_at', 'desc')->first();

            return $getUserRoles;

        } else {

            $user_data->roles()->attach($user_role, ['department_id' => $department_id]);
            $user_data->permissions()->attach($user_perm);

            $getUserRoles = User::with('roles', 'permissions')
                ->where('users.id', $user_id)->orderBy('created_at', 'desc')->first();

            return $getUserRoles;
        }
    }

    public function userStatusChange(Request $request)
    {

        $user_id = $request->input('user_id');
        $status = $request->input('status');

        $user = User::find($user_id);
        $user->status = $status;
        $user->save();

        return redirect('users');
    }

    public function deleteUser(Request $request)
    {

        $id = $request->input('id');

        $success = DB::table('users')->delete($id);

        return $success;
    }

    public function deleteUserRole(Request $request)
    {
        $role_id = $request->input('id');
        $user_id = $request->input('user_id');

        $user_dept_id = User::select('department_id')->where('id', $user_id)->first();
        $dept_id = $user_dept_id->department_id;

        $deleted_user_roles = DB::table('users_roles')->where('user_id', '=', $user_id)
            ->where('department_id', '=', $dept_id)
            ->delete();

        $deleted_user_permissions = DB::table('roles_permissions')->where('user_id', '=', $user_id)
            ->delete();

        return $deleted_user_permissions;
    }

    public function registerDepartment(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'department_name' => 'required|unique:department|max:20',
        ]);

        if ($validator->fails()) {

            return \Illuminate\Support\Facades\Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400);
        } else {

            $dept_name = $request->input('department_name');

            $record = Department::firstOrCreate(['department_name' => $dept_name]);
            $last_id = $record->id;

            if ($last_id) {

                return $last_id;
            }
        }
    }

    public function departmentDetails(Request $request)
    {

        $department_id = $request->input('id');
        $data['department_users'] = User::with('department', 'roles')->where('department_id', $department_id)->get();

        $returnHTML = view('ajaxViews.users.department_users', $data)->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));

    }

    public function getPermissions(Request $request)
    {

        $role_id = $request->input('id');
        $data['user'] = $request->input('user');
        $permissions = array();

        $data['role_permissions'] = Role::with('permissions')->where('id', $role_id)->get();
        $data['all_permissions'] = Permission::all();

        foreach ($data['role_permissions'] as $role) {
            foreach ($role->permissions as $permission) {

                $permissions[] = $permission->slug;
            }
        }

        $data['permissions'] = $permissions;

        $returnHTML = view('ajaxViews.users.edit_user_permissions', $data)->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }

    public function assignUserDepartment(Request $request)
    {
        $user_id = $request->input('user');
        $department_id = $request->input('department');

        $updated = User::updateOrCreate(['id' => $user_id], ['department_id' => $department_id]);

        return $updated;
    }

    public function deleteDepartment(Request $request)
    {

        $department_id = $request->input('id');

        $destroy = DB::table('department')->where('id', $department_id)->delete();

        return $destroy;

    }

    public function userProfile($user)
    {

        $data['user'] = User::with('department')->where('name', 'LIKE', $user)->first();

        $user_id = Auth::id();

        $data['getUserRoles'] = User::with('roles', 'rolesPermissions')
            ->where('users.id', $user_id)->first();

        return view('users.user_profile', $data);

    }

    public function updateUserPassword(Request $request)
    {
        if (Auth::Check()) {

            $request_data = $request->All();
            $validator = $this->password_rules($request_data);

            if ($validator->fails()) {
                return response()->json(array('error' => $validator->getMessageBag()->toArray()), 400);
            } else {
                $current_password = Auth::User()->password;

                if (Hash::check($request_data['current_password'], $current_password)) {

                    $user_id = Auth::User()->id;
                    $obj_user = User::find($user_id);
                    $obj_user->password = Hash::make($request_data['password']);;
                    $obj_user->save();

                    return $obj_user;
                } else {
                    $error = array('current-password' => 'Please enter correct current password');
                    return response()->json(array('error' => $error), 400);
                }
            }
        } else {
            return redirect()->to('login');
        }
    }

    public function password_rules(array $data)
    {
        $messages = [
            'current_password.required' => 'Please enter current password',
            'password.required' => 'Please enter password',
        ];

        $validator = Validator::make($data, [
            'current_password' => 'required',
            'password' => 'required|same:password',
            'password_confirmation' => 'required|same:password',
        ], $messages);

        return $validator;
    }
}
