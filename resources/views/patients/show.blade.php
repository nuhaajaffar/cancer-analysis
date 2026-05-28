@extends('layouts.app')

@section('content')
    <h2>Patient Details</h2>

    <p><strong>Name:</strong> {{ $patient->name }}</p>
    <p><strong>Email:</strong> {{ $patient->email }}</p>
    <p><strong>Role:</strong> {{ $patient->role }}</p>

    <a href="{{ route('patients.index') }}" class="btn">Back to Patient List</a>

    <br><br>

    @if(session('user_role') === 'radiographer')
        <a href="{{ route('scans.create', $patient->id) }}" class="btn">
            Upload Scan
        </a>
    @endif

    @if(session('user_role') === 'radiologist')
        <a href="{{ route('reports.create', $patient->id) }}" class="btn">
            Upload Report
        </a>
    @endif

    <hr>

    <h3>Uploaded Scans</h3>

    @if($patient->scans->count())

        <ul>

        @foreach($patient->scans as $scan)

            <li>
                <a
                    href="{{ asset('storage/' . $scan->file_path) }}"
                    target="_blank">

                    View Scan
                </a>
            </li>

        @endforeach

        </ul>

    @else

        <p>No scans uploaded.</p>

    @endif

    <hr>

    <h3>Uploaded Reports</h3>

    @if($patient->reports->count())

        <ul>
            @foreach($patient->reports as $report)
                <li>
                    <a
                        href="{{ asset('storage/' . $report->report_path) }}"
                        target="_blank">
                        View Report
                    </a>

                    - Status: {{ $report->status }}

                    <br>

                    @if(session('user_role') === 'doctor')
                        <a href="{{ route('doctor-reviews.create', $report->id) }}" class="btn">
                            Add Doctor Review
                        </a>
                    @endif

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
                        <p>No doctor reviews yet.</p>
                    @endif
                </li>
            @endforeach
        </ul>

    @else

        <p>No reports uploaded.</p>

    @endif

    @if(in_array(session('user_role'), ['admin', 'doctor', 'radiographer', 'radiologist']))
    
        <a href="{{ route('appointments.create', $patient->id) }}" class="btn">

            Create Appointment
            
        </a>
        
    @endif

@endsection