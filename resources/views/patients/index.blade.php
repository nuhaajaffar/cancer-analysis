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
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Assigned Doctor</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($patients as $patient)
                    <tr>
                        <td>{{ $patient->name }}</td>
                        <td>{{ $patient->email }}</td>
                        <td>{{ $patient->assignedDoctor->name ?? 'Not assigned' }}</td>
                        <td>
                            <a href="{{ route('patients.show', $patient->id) }}" class="btn">
                                View
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection