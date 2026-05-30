@extends('layouts.app')

@section('content')
    <h2>Patient Dashboard</h2>
    <p>Your Cancer Analysis record summary.</p>

    <ul>
        @include('components.stat-card', ['title' => 'My Scans', 'value' => $stats['myScans']])
        @include('components.stat-card', ['title' => 'My Reports', 'value' => $stats['myReports']])
        @include('components.stat-card', ['title' => 'My Appointments', 'value' => $stats['myAppointments']])
    </ul>

    <a href="{{ route('patients.my-records') }}" class="btn">
        View My Records
    </a>
@endsection