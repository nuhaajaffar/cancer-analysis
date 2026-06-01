@extends('layouts.app')

@section('content')
    <h2>Radiographer Dashboard</h2>
    <p>Upload and manage patient scans.</p>

        @include('components.stat-card', ['title' => 'Total Patients', 'value' => $stats['totalPatients']])
        @include('components.stat-card', ['title' => 'Total Scans', 'value' => $stats['totalScans']])
        @include('components.stat-card', ['title' => 'Pending AI Analyses', 'value' => $stats['pendingAI']])

    <hr>

    <h3>Recent Notifications</h3>

    @if($recentNotifications->count())
        <ul>
            @foreach($recentNotifications as $notification)
                <li>
                    <strong>{{ $notification->title }}</strong>
                    - {{ $notification->message }}
                </li>
            @endforeach
        </ul>
    @else
        <p>No recent notifications.</p>
    @endif

    <hr>

    <h3>Recent Appointments</h3>

    @if($recentAppointments->count())
        <ul>
            @foreach($recentAppointments as $appointment)
                <li>
                    {{ $appointment->patient->name ?? 'Unknown Patient' }}
                    -
                    {{ $appointment->appointment_date }}
                    -
                    {{ $appointment->status }}
                </li>
            @endforeach
        </ul>
    @else
        <p>No recent appointments.</p>
    @endif

    <hr>

    <h3>Recent Reports</h3>

    @if($recentReports->count())
        <ul>
            @foreach($recentReports as $report)
                <li>
                    {{ $report->patient->name ?? 'Unknown Patient' }}
                    -
                    {{ $report->status }}
                </li>
            @endforeach
        </ul>
    @else
        <p>No recent reports.</p>
    @endif
@endsection