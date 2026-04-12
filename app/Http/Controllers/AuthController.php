<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password_hash)) {
            Session::put('admin_login', true);
            Session::put('admin_id', $admin->id);

            return redirect('/admin');
        }

        return back()->with('error', 'Username atau password salah');
    }

    public function logout()
    {
        Session::forget('admin_login');
        return redirect('/login');
    }
}