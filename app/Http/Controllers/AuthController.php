<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    private $api;
    
    public function __construct()
    {
        $this->api = env('API_URL');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $response = Http::post($this->api . '/login', [
            'name' => $request->name,
            'password' => $request->password
        ]);

        if ($response->failed()) {
            return back()->with('error', $response->json()['error'] ?? 'Error de login')->withInput();
        }

        session([
            'token' => $response->json()['token'],
            'user_name' => $request->name
        ]);

        return redirect('/pacientes');
    }

    public function logout()
    {
        session()->forget('token');
        session()->forget('user_name');
        return redirect('/login');
    }
}
