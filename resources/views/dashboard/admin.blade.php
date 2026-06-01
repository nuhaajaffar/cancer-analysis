@extends('layouts.app')

@section('content')
    <h2>Admin Dashboard</h2>
    <p>System overview for Cancer Analysis.</p>

        @include('components.stat-card', ['title' => 'Total Patients', 'value' => $stats['totalPatients']])
        @include('components.stat-card', ['title' => 'Total Scans', 'value' => $stats['totalScans']])
        @include('components.stat-card', ['title' => 'Total Reports', 'value' => $stats['totalReports']])
        @include('components.stat-card', ['title' => 'Total Appointments', 'value' => $stats['totalAppointments']])
        @include('components.stat-card', ['title' => 'Pending AI Analyses', 'value' => $stats['pendingAI']])
        @include('components.stat-card', ['title' => 'Completed AI Analyses', 'value' => $stats['completedAI']])
        @include('components.stat-card', ['title' => 'Failed AI Analyses', 'value' => $stats['failedAI']])

    <hr>

    <h3>Appointment Statistics</h3>

    <ul>
        <li>Scheduled: {{ $appointmentStats['scheduled'] }}</li>
        <li>Completed: {{ $appointmentStats['completed'] }}</li>
        <li>Cancelled: {{ $appointmentStats['cancelled'] }}</li>
    </ul>

    <hr>

    <h3>AI Analysis Statistics</h3>

    <ul>
        <li>Pending: {{ $aiStats['pending'] }}</li>
        <li>Completed: {{ $aiStats['completed'] }}</li>
        <li>Failed: {{ $aiStats['failed'] }}</li>
    </ul>

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