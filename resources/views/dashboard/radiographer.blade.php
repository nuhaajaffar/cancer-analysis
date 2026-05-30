@extends('layouts.app')

@section('content')
    <h2>Radiographer Dashboard</h2>
    <p>Upload and manage patient scans.</p>

    <ul>
        <li>Total Patients: {{ $stats['totalPatients'] }}</li>
        <li>Total Uploaded Scans: {{ $stats['totalScans'] }}</li>
        <li>Pending AI Analyses: {{ $stats['pendingAI'] }}</li>
    </ul>
@endsection