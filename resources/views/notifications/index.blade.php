@extends('layouts.app')

@section('content')
    <h2>Notifications</h2>

    @if($notifications->count())
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Message</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($notifications as $notification)
                    <tr>
                        <td>{{ $notification->title }}</td>
                        <td>{{ $notification->message }}</td>
                        <td>{{ $notification->type ?? 'general' }}</td>
                        <td>{{ $notification->is_read ? 'Read' : 'Unread' }}</td>
                        <td>
                            @if(!$notification->is_read)
                                <form
                                    action="{{ route('notifications.read', $notification->id) }}"
                                    method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="btn">
                                        Mark as Read
                                    </button>
                                </form>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No notifications yet.</p>
    @endif
@endsection