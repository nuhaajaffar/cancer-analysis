@extends('layouts.app')

@section('content')
    <h2>Notifications</h2>

    @if($notifications->count())
        <ul>
            @foreach($notifications as $notification)
                <li>
                    <strong>{{ $notification->title }}</strong>
                    <br>
                    {{ $notification->message }}
                    <br>
                    <small>Type: {{ $notification->type ?? 'general' }}</small>
                    <br>
                    <small>Status: {{ $notification->is_read ? 'Read' : 'Unread' }}</small>

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
                    @endif
                </li>
                <br>
            @endforeach
        </ul>
    @else
        <p>No notifications yet.</p>
    @endif
@endsection