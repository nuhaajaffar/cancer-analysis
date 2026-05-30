@extends('layouts.app')

@section('content')

    <h2>Appointments</h2>

    <form method="GET" action="{{ route('appointments.index') }}">
        <label>Filter by Status</label>

        <select name="status">
            <option value="">All</option>
            <option value="scheduled" {{ $status === 'scheduled' ? 'selected' : '' }}>
                Scheduled
            </option>
            <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>
                Completed
            </option>
            <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>
                Cancelled
            </option>
        </select>

        <button type="submit" class="btn">Filter</button>

        <a href="{{ route('appointments.index') }}" class="btn">Reset</a>
    </form>

    <br>

    @if($appointments->count())

        <ul>
            @foreach($appointments as $appointment)
                <li>
                    <strong>Patient:</strong> {{ $appointment->patient->name }}
                    <br>
                    <strong>Staff:</strong> {{ $appointment->staff->name }}
                    <br>
                    <strong>Date:</strong> {{ $appointment->appointment_date }}
                    <br>
                    <strong>Purpose:</strong> {{ $appointment->purpose }}
                    <br>
                    <strong>Status:</strong> {{ $appointment->status }}

                    <br><br>

                    <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn">
                        Edit
                    </a>

                    @if($appointment->status !== 'cancelled')
                        <form
                            action="{{ route('appointments.cancel', $appointment->id) }}"
                            method="POST"
                            style="display:inline;">

                            @csrf
                            @method('PATCH')

                            <button type="submit" class="btn btn-danger">
                                Cancel
                            </button>
                        </form>
                    @endif
                </li>

                <br>
            @endforeach
        </ul>

    @else

        <p>No appointments found.</p>

    @endif

@endsection