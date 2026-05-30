@extends('layouts.app')

@section('content')
    <h2>Admin Dashboard</h2>
    <p>System overview for Cancer Analysis.</p>

    <ul>
        <li>Total Patients: {{ $stats['totalPatients'] }}</li>
        <li>Total Scans: {{ $stats['totalScans'] }}</li>
        <li>Total Reports: {{ $stats['totalReports'] }}</li>
        <li>Total Appointments: {{ $stats['totalAppointments'] }}</li>
        <li>Pending AI Analyses: {{ $stats['pendingAI'] }}</li>
        <li>Completed AI Analyses: {{ $stats['completedAI'] }}</li>
        <li>Failed AI Analyses: {{ $stats['failedAI'] }}</li>
    </ul>
@endsection