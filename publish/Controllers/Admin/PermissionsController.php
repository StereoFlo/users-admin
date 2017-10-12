<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Permission;
use Illuminate\Http\Request;
use Session;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 15;

        if (empty($keyword)) {
            $permissions = Permission::paginate($perPage);
            return view('admin.permissions.index', ['permissions' => $permissions]);
        }
        $permissions = Permission::search($keyword, $perPage);
        return view('admin.permissions.index', ['permissions' => $permissions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required']);

        Permission::create($request->all());

        Session::flash('flash_message', 'Permission added!');

        return redirect('permissions');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        $permission = Permission::findOrFail($id);

        return view('admin.permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        return view('admin.permissions.edit', ['permission' => Permission::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request $request
     */
    public function update($id, Request $request)
    {
        $this->validate($request, ['name' => 'required']);
        $permission = Permission::findOrFail($id);
        $permission->update($request->all());
        Session::flash('flash_message', 'Permission updated!');

        return redirect('permissions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        Permission::destroy($id);
        Session::flash('flash_message', 'Permission deleted!');
        return redirect('permissions');
    }
}
