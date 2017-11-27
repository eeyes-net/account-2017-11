<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        return Permission::all();
    }

    public function store(Request $request)
    {
        $permission = Permission::create($request->validate([
            'name' => 'required|unique:roles,name',
            'display_name' => 'required',
            'description' => 'required',
        ]));
        return $permission;
    }

    public function show(Permission $permission)
    {
        return $permission;
    }

    public function update(Request $request, Permission $permission)
    {
        $permission->update($request->only([
            'name',
            'display_name',
            'description',
        ]));
        return $permission;
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return $permission;
    }
}
