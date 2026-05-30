@extends('layouts.app')

@section('content')
    <h2>Radiographer Dashboard</h2>
    <p>Upload and manage patient scans.</p>

    <ul>
        @include('components.stat-card', ['title' => 'Total Patients', 'value' => $stats['totalPatients']])
        @include('components.stat-card', ['title' => 'Total Scans', 'value' => $stats['totalScans']])
        @include('components.stat-card', ['title' => 'Pending AI Analyses', 'value' => $stats['pendingAI']])
    </ul>
@endsection