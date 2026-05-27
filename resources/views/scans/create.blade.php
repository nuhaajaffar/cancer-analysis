@extends('layouts.app')

@section('content')

<h2>Upload Scan</h2>

<p>
    Patient:
    {{ $patient->name }}
</p>

<form
    action="{{ route('scans.store', $patient->id) }}"
    method="POST"
    enctype="multipart/form-data">

    @csrf

    <input
        type="file"
        name="scan"
        required>

    <br><br>

    <button
        type="submit"
        class="btn">
        Upload Scan
    </button>

</form>

@endsection