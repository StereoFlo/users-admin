<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Session;

class AdminController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        return view('admin.dashboard');
    }

    /**
     * @return mixed
     */
    public function getGiveRolePermissions()
    {
        return view('admin.permissions.role-give-permissions', ['roles' => Role::getRoles(), 'permissions' => Permission::getPermissions()]);
    }

    /**
     * Store given permissions to role.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return void
     */
    public function postGiveRolePermissions(Request $request)
    {
        $this->validate($request, ['role' => 'required', 'permissions' => 'required']);

        $role = Role::getByNameWithPermission($request->role);
        $role->permissions()->detach();

        foreach ($request->permissions as $permissionName) {
            $role->givePermissionTo(Permission::getByName($permissionName));
        }

        Session::flash('flash_message', 'Permission granted!');

        return redirect('roles');
    }
}
