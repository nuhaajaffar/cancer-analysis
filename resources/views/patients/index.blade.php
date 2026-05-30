@extends('layouts.app')

@section('content')
    <h2>Patient List</h2>

    <form method="GET" action="{{ route('patients.index') }}">
        <input
            type="text"
            name="search"
            value="{{ $search }}"
            placeholder="Search patient by name or email">

        <button type="submit" class="btn">Search</button>

        <a href="{{ route('patients.index') }}" class="btn">Reset</a>
    </form>

    <br>

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