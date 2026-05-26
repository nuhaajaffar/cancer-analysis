@extends('layouts.app')

@section('content')
    <h2>Patient Details</h2>

    <p><strong>Name:</strong> {{ $patient->name }}</p>
    <p><strong>Email:</strong> {{ $patient->email }}</p>
    <p><strong>Role:</strong> {{ $patient->role }}</p>

    <a href="{{ route('patients.index') }}" class="btn">Back to Patient List</a>
@endsection