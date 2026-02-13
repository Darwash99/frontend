<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PacienteController extends Controller
{
    private $api;
    
    public function __construct()
    {
        $this->api = env('API_URL');
    }

    public function index()
    {
        if (!session('token')) {
            return redirect('/login');
        }
        // $response = Http::withToken(session('token'))
        //     ->get($this->api . '/pacientes');
        // if ($response->failed()) {
        //     return redirect('/login')->with('error', 'Sesión expirada');
        // }
        // $pacientes = $response->json();

        return view('pacientes.index');
    }
}
