@extends('layouts.app')

@section('content')
    <h2>Radiologist Dashboard</h2>
    <p>Upload reports and review AI-supported scan findings.</p>

    <ul>
        @include('components.stat-card', ['title' => 'Total Patients', 'value' => $stats['totalPatients']])
        @include('components.stat-card', ['title' => 'Total Scans', 'value' => $stats['totalScans']])
        @include('components.stat-card', ['title' => 'Total Reports', 'value' => $stats['totalReports']])
        @include('components.stat-card', ['title' => 'Completed AI Analyses', 'value' => $stats['completedAI']])
        @include('components.stat-card', ['title' => 'Failed AI Analyses', 'value' => $stats['failedAI']])
    </ul>
@endsection