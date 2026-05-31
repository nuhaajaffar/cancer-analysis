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