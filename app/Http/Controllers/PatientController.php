<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PatientController extends Controller
{
    public function index()
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        $patients = User::where('role', 'patient')->get();

        return view('patients.index', compact('patients'));
    }

    public function show($id)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        $patient = User::with('scans')->where('role', 'patient')->findOrFail($id);

        return view('patients.show', compact('patient'));
    }}