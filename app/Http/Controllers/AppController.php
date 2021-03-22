<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    function index(){
        if(\Auth::check()) {
            return view("app.main");
        }

//        return redirect()->to("/login");
    }
}
