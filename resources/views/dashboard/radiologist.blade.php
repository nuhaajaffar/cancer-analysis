@extends('layouts.app')

@section('content')
    <h2>Radiologist Dashboard</h2>
    <p>Upload reports and review AI-supported scan findings.</p>

    <ul>
        <li>Total Patients: {{ $stats['totalPatients'] }}</li>
        <li>Total Scans: {{ $stats['totalScans'] }}</li>
        <li>Total Reports: {{ $stats['totalReports'] }}</li>
        <li>Completed AI Analyses: {{ $stats['completedAI'] }}</li>
        <li>Failed AI Analyses: {{ $stats['failedAI'] }}</li>
    </ul>
@endsection