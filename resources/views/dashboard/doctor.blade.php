@extends('layouts.app')

@section('content')
    <h2>Doctor Dashboard</h2>
    <p>Review patient reports and AI analysis results.</p>

    <ul>
        <li>Total Patients: {{ $stats['totalPatients'] }}</li>
        <li>Total Reports: {{ $stats['totalReports'] }}</li>
        <li>Total Appointments: {{ $stats['totalAppointments'] }}</li>
        <li>Completed AI Analyses: {{ $stats['completedAI'] }}</li>
        <li>Pending AI Analyses: {{ $stats['pendingAI'] }}</li>
    </ul>
@endsection