@extends('layouts.app')

@section('content')
    <h2>Doctor Dashboard</h2>
    <p>Review patient reports and AI analysis results.</p>

    <ul>
        @include('components.stat-card', ['title' => 'Total Patients', 'value' => $stats['totalPatients']])
        @include('components.stat-card', ['title' => 'Total Reports', 'value' => $stats['totalReports']])
        @include('components.stat-card', ['title' => 'Total Appointments', 'value' => $stats['totalAppointments']])
        @include('components.stat-card', ['title' => 'Completed AI Analyses', 'value' => $stats['completedAI']])
        @include('components.stat-card', ['title' => 'Pending AI Analyses', 'value' => $stats['pendingAI']])
    </ul>
@endsection