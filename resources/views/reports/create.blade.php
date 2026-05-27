@extends('layouts.app')

@section('content')

<h2>Upload Patient Report</h2>

<p>
    Patient:
    {{ $patient->name }}
</p>

<form
    action="{{ route('reports.store', $patient->id) }}"
    method="POST"
    enctype="multipart/form-data">

    @csrf

    <label>Upload Report PDF</label>
    <input
        type="file"
        name="report"
        accept="application/pdf"
        required>

    <br><br>

    <button
        type="submit"
        class="btn">
        Upload Report
    </button>

</form>

@endsection