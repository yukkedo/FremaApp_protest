<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // public function registerRedirect(Request $request)
    // {
    //     $user = Auth::user();
    //     return redirect('/mypage', compact('user'));
    // }

    public function loginRedirect(Request $request)
    {
        return redirect('/');
    }

    public function loginShow()
    {
        return view('auth.login');
    }
}
