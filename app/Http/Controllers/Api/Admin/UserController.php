<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return User::latest()->paginate();
    }

    public function store(Request $request)
    {
        $user = User::newByNetId($request->post('username'));
        $user->save();
        if ($request->has('role_ids')) {
            $roles = $request->post('role_ids', []);
            $user->roles()->sync($roles);
        }
        return $user;
    }

    public function show(User $user)
    {
        return $user;
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->validate([
            'email' => 'email',
            'mobile' => 'numeric',
        ]));
        if ($request->has('role_ids')) {
            $roles = $request->post('role_ids', []);
            $user->roles()->sync($roles);
        }
        return $user;
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $user;
    }
}
