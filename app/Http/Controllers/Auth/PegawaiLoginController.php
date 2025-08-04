<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PegawaiLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('pegawai.login');
    }

    public function login(Request $request)
{
    $credentials = $request->only('nip', 'password');

    if (Auth::guard('pegawai')->attempt($credentials)) {
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors(['nip' => 'NIP atau password salah.'])->withInput();
}

    public function logout(Request $request)
    {
        Auth::guard('pegawai')->logout();
        return redirect('/login');
    }
}

?>