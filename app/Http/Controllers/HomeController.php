<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function index()
    {
        if (Auth::user()->role === 'teacher') {
            return redirect('/teacher/dashboard');
        } else {
            return redirect('/student/dashboard');
        }
    }
}
