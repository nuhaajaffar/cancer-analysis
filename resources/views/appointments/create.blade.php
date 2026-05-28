@extends('layouts.app')

@section('content')

<h2>Create Appointment</h2>

    <p><strong>Patient:</strong> {{ $patient->name }}</p>

    <form action="{{ route('appointments.store', $patient->id) }}" method="POST">
        @csrf

        <label>Appointment Date and Time</label>
        <input type="datetime-local" name="appointment_date" required>

        <label>Purpose</label>
        <input type="text" name="purpose" placeholder="e.g. Follow-up consultation" required>

        <button type="submit" class="btn">Create Appointment</button>
    </form>

@endsection