@extends('layouts.app')

@section('content')
    <h2>My Medical Records</h2>

    <p><strong>Name:</strong> {{ $patient->name }}</p>
    <p><strong>Email:</strong> {{ $patient->email }}</p>

    <hr>

    <h3>My Scans</h3>

    @if($patient->scans->count())
        <ul>
            @foreach($patient->scans as $scan)
                <li>
                    <a href="{{ asset('storage/' . $scan->file_path) }}" target="_blank">
                        View Scan
                    </a>
                    |
                    <a href="{{ route('scans.download', $scan->id) }}">
                        Download Scan
                    </a>

                    <br>

                    <strong>AI Status:</strong> {{ $scan->ai_status }}

                    @if($scan->ai_prediction)
                        <br>
                        <strong>Prediction:</strong> {{ $scan->ai_prediction }}
                        <br>
                        <strong>Confidence:</strong> {{ $scan->ai_confidence }}%
                    @endif

                    <br>
                    <strong>Uploaded At:</strong>
                    {{ $scan->created_at->format('Y-m-d H:i') }}
                </li>
                <br>
            @endforeach
        </ul>
    @else
        <p>No scans uploaded yet.</p>
    @endif

    <hr>

    <h3>My Reports</h3>

    @if($patient->reports->count())
        <ul>
            @foreach($patient->reports as $report)
                <li>
                    <a href="{{ asset('storage/' . $report->report_path) }}" target="_blank">
                        View Report
                    </a>
                    |
                    <a href="{{ route('reports.download', $report->id) }}">
                        Download Report
                    </a>

                    <br>

                    <strong>Status:</strong> {{ $report->status }}
                    <br>
                    <strong>Uploaded At:</strong>
                    {{ $report->created_at->format('Y-m-d H:i') }}

                    @if($report->reviews->count())
                        <ul>
                            @foreach($report->reviews as $review)
                                <li>
                                    <strong>Doctor:</strong>
                                    {{ $review->doctor->name ?? 'Unknown Doctor' }}
                                    <br>
                                    <strong>Review:</strong>
                                    {{ $review->review }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No doctor review yet.</p>
                    @endif
                </li>
                <br>
            @endforeach
        </ul>
    @else
        <p>No reports uploaded yet.</p>
    @endif

    <hr>

    <h3>My Appointments</h3>

    @if($patient->patientAppointments->count())
        <ul>
            @foreach($patient->patientAppointments as $appointment)
                <li>
                    <strong>Date:</strong> {{ $appointment->appointment_date }}
                    <br>
                    <strong>With:</strong>
                    {{ $appointment->staff->name ?? 'Unknown Staff' }}
                    <br>
                    <strong>Purpose:</strong> {{ $appointment->purpose }}
                    <br>
                    <strong>Status:</strong> {{ $appointment->status }}
                </li>
                <br>
            @endforeach
        </ul>
    @else
        <p>No appointments scheduled.</p>
    @endif
@endsection