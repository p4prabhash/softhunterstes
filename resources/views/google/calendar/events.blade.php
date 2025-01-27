@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Google Calendar Events</h2>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if (!empty($events))
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Start</th>
                    <th>End</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $event)
                    <tr>
                        <td>{{ $event->getSummary() ?? 'No Title' }}</td>
                        <td>{{ $event->start->dateTime ?? $event->start->date }}</td>
                        <td>{{ $event->end->dateTime ?? $event->end->date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No upcoming events found.</p>
    @endif
</div>
@endsection
