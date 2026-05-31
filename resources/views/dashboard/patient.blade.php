@extends('layouts.app')

@section('content')
    <h2>Patient Dashboard</h2>
    <p>Your Cancer Analysis record summary.</p>

    @include('components.stat-card', [
        'title' => 'My Scans',
        'value' => $stats['myScans']
    ])

    @include('components.stat-card', [
        'title' => 'My Reports',
        'value' => $stats['myReports']
    ])

    @include('components.stat-card', [
        'title' => 'My Appointments',
        'value' => $stats['myAppointments']
    ])

    <a href="{{ route('patients.my-records') }}" class="btn">
        View My Records
    </a>

    <hr>

    <h3>Recent Notifications</h3>

    @if($recentNotifications->count())
        <ul>
            @foreach($recentNotifications as $notification)
                <li>
                    <strong>{{ $notification->title }}</strong>
                    -
                    {{ $notification->message }}
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
                    {{ $report->status }}
                </li>
            @endforeach
        </ul>
    @else
        <p>No recent reports.</p>
    @endif

@endsection