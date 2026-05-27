@extends('layouts.app')

@section('content')

<h2>Add Doctor Review</h2>

<p>
    Report ID:
    {{ $report->id }}
</p>

<form
    action="{{ route('doctor-reviews.store', $report->id) }}"
    method="POST">

    @csrf

    <label>Review Notes</label>

    <textarea
        name="review"
        rows="6"
        required
        style="width: 100%; padding: 10px;"></textarea>

    <br><br>

    <button
        type="submit"
        class="btn">
        Save Review
    </button>

</form>

@endsection