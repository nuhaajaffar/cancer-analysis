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
        <table style="width:100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Staff</th>
                    <th>Date</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->patient->name }}</td>
                        <td>{{ $appointment->staff->name }}</td>
                        <td>{{ $appointment->appointment_date }}</td>
                        <td>{{ $appointment->purpose }}</td>
                        <td>{{ $appointment->status }}</td>
                        <td>
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
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No appointments found.</p>
    @endif

@endsection