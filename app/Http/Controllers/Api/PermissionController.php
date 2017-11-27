<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    public function can(Request $request)
    {
        /** @var \App\User $user */
        $user = Auth::user();
        return [
            'can' => $user->can($request->get('permission')),
        ];
    }

    public function all()
    {
        /** @var \App\User $user */
        $user = Auth::user();
        return $user->permNames();
    }
}
