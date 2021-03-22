<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\RequestStack;

class AuthController extends Controller
{
    public $successStatus = 200;
    public function details(Request $request){
        $user = \Auth::user();
        dd($user);
        if (!$user) {
            \Auth::logout();
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        return response()->json($user, $this->successStatus);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('solutech')->accessToken;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
