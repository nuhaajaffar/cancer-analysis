@extends('layouts.app')

@section('content')
    <h2>Patient Dashboard</h2>
    <p>Your Cancer Analysis record summary.</p>

    <ul>
        <li>My Scans: {{ $stats['myScans'] }}</li>
        <li>My Reports: {{ $stats['myReports'] }}</li>
        <li>My Appointments: {{ $stats['myAppointments'] }}</li>
    </ul>

    <a href="{{ route('patients.my-records') }}" class="btn">
        View My Records
    </a>
@endsection