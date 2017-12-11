<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function has(Request $request)
    {
        /** @var \App\User $user */
        $user = Auth::user();
        return [
            'has' => $user->hasRole($request->get('role')),
        ];
    }
}
