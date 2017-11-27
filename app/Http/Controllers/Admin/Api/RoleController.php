<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return Role::all();
    }

    public function store(Request $request)
    {
        $role = Role::create($request->validate([
            'name' => 'required|unique:roles,name',
            'display_name' => 'required',
            'description' => 'required',
        ]));
        if ($request->has('perm_ids')) {
            $perms = $request->post('perm_ids', []);
            $role->perms()->sync($perms);
        }
        return $role;
    }

    public function show(Role $role)
    {
        return $role;
    }

    public function update(Request $request, Role $role)
    {
        $role->update($request->only([
            'name',
            'display_name',
            'description',
        ]));
        if ($request->has('perm_ids')) {
            $perms = $request->post('perm_ids', []);
            $role->perms()->sync($perms);
        }
        return $role;
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return $role;
    }
}
