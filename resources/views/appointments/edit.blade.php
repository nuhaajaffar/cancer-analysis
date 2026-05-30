@extends('layouts.app')

@section('content')
    <h2>Edit Appointment</h2>

    <p><strong>Patient:</strong> {{ $appointment->patient->name }}</p>
    <p><strong>Staff:</strong> {{ $appointment->staff->name }}</p>

    <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Appointment Date and Time</label>
        <input
            type="datetime-local"
            name="appointment_date"
            value="{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d\TH:i') }}"
            required>

        <label>Purpose</label>
        <input
            type="text"
            name="purpose"
            value="{{ $appointment->purpose }}"
            required>

        <label>Status</label>
        <select name="status" required>
            <option value="scheduled" {{ $appointment->status === 'scheduled' ? 'selected' : '' }}>
                Scheduled
            </option>

            <option value="completed" {{ $appointment->status === 'completed' ? 'selected' : '' }}>
                Completed
            </option>

            <option value="cancelled" {{ $appointment->status === 'cancelled' ? 'selected' : '' }}>
                Cancelled
            </option>
        </select>

        <br><br>

        <button type="submit" class="btn">
            Update Appointment
        </button>
    </form>

    <br>

    <a href="{{ route('appointments.index') }}" class="btn">
        Back to Appointments
    </a>
@endsection