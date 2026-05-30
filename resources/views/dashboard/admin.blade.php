@extends('layouts.app')

@section('content')
    <h2>Admin Dashboard</h2>
    <p>System overview for Cancer Analysis.</p>

    <ul>
        @include('components.stat-card', ['title' => 'Total Patients', 'value' => $stats['totalPatients']])
        @include('components.stat-card', ['title' => 'Total Scans', 'value' => $stats['totalScans']])
        @include('components.stat-card', ['title' => 'Total Reports', 'value' => $stats['totalReports']])
        @include('components.stat-card', ['title' => 'Total Appointments', 'value' => $stats['totalAppointments']])
        @include('components.stat-card', ['title' => 'Pending AI Analyses', 'value' => $stats['pendingAI']])
        @include('components.stat-card', ['title' => 'Completed AI Analyses', 'value' => $stats['completedAI']])
        @include('components.stat-card', ['title' => 'Failed AI Analyses', 'value' => $stats['failedAI']])
    </ul>
@endsection