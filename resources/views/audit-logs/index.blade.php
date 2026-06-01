@extends('layouts.app')

@section('content')
    <h2>Audit Logs</h2>

    @if($auditLogs->count())
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Action</th>
                    <th>Target</th>
                    <th>Description</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>
                @foreach($auditLogs as $log)
                    <tr>
                        <td>{{ $log->user->name ?? 'System/Deleted User' }}</td>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->target_type }} #{{ $log->target_id }}</td>
                        <td>{{ $log->description }}</td>
                        <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No audit logs yet.</p>
    @endif
@endsection