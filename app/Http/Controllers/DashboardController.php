<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        $role = session('user_role');

        return match ($role) {
            'admin' => view('dashboard.admin'),
            'doctor' => view('dashboard.doctor'),
            'radiographer' => view('dashboard.radiographer'),
            'radiologist' => view('dashboard.radiologist'),
            'patient' => view('dashboard.patient'),
            default => redirect()->route('login'),
        };
    }
}