@extends('layouts.app')

@section('content')
    <h2>Patient List</h2>

    @if($patients->isEmpty())
        <p>No patients found.</p>
    @else
        <ul>
            @foreach($patients as $patient)
                <li>
                    <a href="{{ route('patients.show', $patient->id) }}">
                        {{ $patient->name }}
                    </a>
                    - {{ $patient->email }}
                </li>
            @endforeach
        </ul>
    @endif
@endsection