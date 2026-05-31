@extends('layouts.app')

@section('content')
    <h2>Patient Details</h2>

    <p><strong>Name:</strong> {{ $patient->name }}</p>
    <p><strong>Email:</strong> {{ $patient->email }}</p>
    <p><strong>Role:</strong> {{ $patient->role }}</p>
    <p><strong>Date of Birth:</strong> {{ $patient->date_of_birth ?? 'Not provided' }}</p>
    <p><strong>Gender:</strong> {{ $patient->gender ?? 'Not provided' }}</p>
    <p><strong>Phone:</strong> {{ $patient->phone ?? 'Not provided' }}</p>
    <p><strong>Address:</strong> {{ $patient->address ?? 'Not provided' }}</p>
    <p><strong>Medical Notes:</strong> {{ $patient->medical_notes ?? 'Not provided' }}</p>

    <hr>

    <h3>Assigned Staff</h3>

    <p><strong>Doctor:</strong> {{ $patient->assignedDoctor->name ?? 'Not assigned' }}</p>
    <p><strong>Radiographer:</strong> {{ $patient->assignedRadiographer->name ?? 'Not assigned' }}</p>
    <p><strong>Radiologist:</strong> {{ $patient->assignedRadiologist->name ?? 'Not assigned' }}</p>

    @if(in_array(session('user_role'), ['admin', 'doctor', 'radiographer', 'radiologist']))
        <a href="{{ route('patients.edit', $patient->id) }}" class="btn">
            Edit Patient Profile
        </a>
    @endif

    <a href="{{ route('patients.index') }}" class="btn">
        Back to Patient List
    </a>

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

                <br>

                <strong>AI Status:</strong> {{ $scan->ai_status }}

                @if($scan->ai_prediction)
                    <br>
                    <strong>Prediction:</strong> {{ $scan->ai_prediction }}
                    <br>
                    <strong>Confidence:</strong> {{ $scan->ai_confidence }}%
                @endif

                @if(in_array(session('user_role'), ['admin', 'doctor', 'radiologist']))
                    @if($scan->ai_status !== 'completed')
                        <form action="{{ route('scans.analyse', $scan->id) }}" method="POST" style="margin-top: 10px;">
                            @csrf
                            <button type="submit" class="btn">
                                Run AI Analysis
                            </button>
                        </form>
                    @else
                        <p>AI analysis already completed.</p>
                    @endif
                @endif
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
                    <strong>Report:</strong>
                    <a
                        href="{{ asset('storage/' . $report->report_path) }}"
                        target="_blank">
                        View
                    </a>

                    |
                    <a href="{{ route('reports.download', $report->id) }}">
                        Download
                    </a>

                    <br>

                    <strong>Status:</strong> {{ $report->status }}
                    <br>

                    <strong>Uploaded By:</strong>
                    {{ $report->uploadedBy->name ?? 'Unknown User' }}
                    <br>

                    <strong>Uploaded At:</strong>
                    {{ $report->created_at->format('Y-m-d H:i') }}

                    @if(in_array(session('user_role'), ['admin', 'radiologist']))
                        <form
                            action="{{ route('reports.destroy', $report->id) }}"
                            method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">
                                Delete Report
                            </button>
                        </form>
                    @endif

                    @if(session('user_role') === 'doctor')
                        <br>
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