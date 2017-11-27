<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show()
    {
        /** @var \App\User $user */
        $user = Auth::user();
        $info = [];
        if ($user->tokenCan('info-username.read')) {
            $info['username'] = $user->username;
        }
        if ($user->tokenCan('info-user_id.read')) {
            $info['user_id'] = $user->user_id;
        }
        if ($user->tokenCan('info-name.read')) {
            $info['name'] = $user->name;
        }
        if ($user->tokenCan('info-email.read')) {
            $info['email'] = $user->email;
        }
        if ($user->tokenCan('info-mobile.read')) {
            $info['mobile'] = $user->mobile;
        }
        if ($user->tokenCan('info-school.read')) {
            $info['dep'] = $user->dep;
            $info['depid'] = $user->depid;
            $info['speciality'] = $user->speciality;
            $info['classid'] = $user->classid;
        }
        if ($user->tokenCan('info-detail.read')) {
            $info['gender'] = $user->gender;
            $info['birthday'] = $user->birthday;
            $info['roomnumber'] = $user->roomnumber;
            $info['marriage'] = $user->marriage;
            $info['nation'] = $user->nation;
            $info['nationplace'] = $user->nationplace;
            $info['polity'] = $user->polity;
            $info['studenttype'] = $user->studenttype;
            $info['tutoremployeeid'] = $user->tutoremployeeid;
            $info['usertype'] = $user->usertype;
            $info['roomphone'] = $user->roomphone;
        }
        if ($user->tokenCan('info-secret.read')) {
            $info['idcardname'] = $user->idcardname;
            $info['idcardno'] = $user->idcardno;
        }
        return $info;
    }

    public function update(Request $request)
    {
        /** @var \App\User $user */
        $user = Auth::user();
        if ($user->tokenCan('info-email.write')
            && $request->has('email')) {
            $user->email = $request->post('email', $user->email);
        }
        if ($user->tokenCan('info-mobile.write')
            && $request->has('mobile')) {
            $user->mobile = $request->post('mobile', $user->mobile);
        }
        $user->save();
        return [
            'code' => 200,
            'message' => 'OK',
        ];
    }
}
