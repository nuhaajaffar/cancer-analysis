@extends('layouts.app')

@section('content')

    <h2>Appointments</h2>

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