@extends('layouts.app')

@section('content')
    <h2>Edit Patient Profile</h2>

    <form action="{{ route('patients.update', $patient->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Name</label>
        <input type="text" name="name" value="{{ $patient->name }}" required>

        <label>Email</label>
        <input type="email" name="email" value="{{ $patient->email }}" required>

        <label>Date of Birth</label>
        <input type="date" name="date_of_birth" value="{{ $patient->date_of_birth }}">

        <label>Gender</label>
        <input type="text" name="gender" value="{{ $patient->gender }}">

        <label>Phone</label>
        <input type="text" name="phone" value="{{ $patient->phone }}">

        <label>Address</label>
        <textarea name="address" rows="3">{{ $patient->address }}</textarea>

        <label>Medical Notes</label>
        <textarea name="medical_notes" rows="4">{{ $patient->medical_notes }}</textarea>

        <hr>

        <h3>Staff Assignment</h3>

        <label>Assigned Doctor</label>
        <select name="assigned_doctor_id">
            <option value="">None</option>
            @foreach($doctors as $doctor)
                <option value="{{ $doctor->id }}"
                    {{ $patient->assigned_doctor_id == $doctor->id ? 'selected' : '' }}>
                    {{ $doctor->name }}
                </option>
            @endforeach
        </select>

        <label>Assigned Radiographer</label>
        <select name="assigned_radiographer_id">
            <option value="">None</option>
            @foreach($radiographers as $radiographer)
                <option value="{{ $radiographer->id }}"
                    {{ $patient->assigned_radiographer_id == $radiographer->id ? 'selected' : '' }}>
                    {{ $radiographer->name }}
                </option>
            @endforeach
        </select>

        <label>Assigned Radiologist</label>
        <select name="assigned_radiologist_id">
            <option value="">None</option>
            @foreach($radiologists as $radiologist)
                <option value="{{ $radiologist->id }}"
                    {{ $patient->assigned_radiologist_id == $radiologist->id ? 'selected' : '' }}>
                    {{ $radiologist->name }}
                </option>
            @endforeach
        </select>

        <br><br>

        <button type="submit" class="btn">
            Update Profile
        </button>
    </form>
@endsection