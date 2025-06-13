<?php

namespace App\Http\Controllers\Auth;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                "email" => 'required|email',
                "password" => 'required|string|max:255'
            ]);

            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                $user = Auth::user();
                session([
                    'user_email' => $user->email,
                    'user_name' => $user->name,
                ]);

                return redirect()->route('dashboard.index')->with('success', 'Berhasil Login');
            } else {
                throw new \Exception('Email atau password salah');
            }
        } catch (\Exception $err) {
            return redirect()->back()->with('error', $err->getMessage());
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
