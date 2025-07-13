<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('pages.login');
    }

    public function authenticate(LoginRequest $request)
    {
        $credentials = $request->validated();  // Gunakan validated() untuk mengambil data yang sudah divalidasi

        if (!Auth::attempt($credentials, $request->filled('remember'))) {
            return back()->with('failed', 'Login failed, please try again');
        }

        $request->session()->regenerate();
        return $this->authenticated($request, Auth::user());
    }

    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'You have been logged out!');
    }
}