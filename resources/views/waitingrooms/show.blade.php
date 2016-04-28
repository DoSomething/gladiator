@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Waiting Rooms',
        'subtitle' => 'Viewing waiting room ' . $room->id
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block -half">
                <h2 class="heading">Information</h2>

                <ul>
                    <li><strong>Campaign ID:</strong> {{ $contest->campaign_id }}</li>
                    <li><strong>Campaign Run ID:</strong> {{ $contest->campaign_run_id }}</li>
                    <li><strong>Contest ID:</strong> <a href="{{ route('contests.show', $room->contest_id) }}">{{ $room->contest_id }}</a></li>
                    <li><strong>Signup Start Date:</strong> {{ $room->signup_start_date->format('F d, Y') }}</li>
                    <li><strong>Signup End Date:</strong> {{ $room->signup_end_date->format('F d, Y') }}</li>
                </ul>
            </div>
            <div class="container__block -half">
                <ul class="form-actions -inline">
                    <li>
                        <a href="{{ route('waitingrooms.edit', $room->id) }}" class="button">Edit</a>
                    </li>
                    @if (has_signup_period_ended($room->signup_end_date))
                        <li>
                            <a href="{{ route('split', $room->id) }}" class="button -secondary">Split room</a>
                        </li>
                    @endif
                </ul>
            </div>

        </div>
    </div>

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
            <h2 class="heading">Data export</h1>
                <ul class="list">
                    <li><a href="{{ route('waitingrooms.export', $room->id) }}">&DownArrowBar; Export</a> &mdash; CSV list of users for this waiting room</li>
                </ul>
            </div>
        </div>
    </div>

    @include('users.partials._table_users', ['users' => $users, 'role' => 'Signups: ' . $room->users->count()])

@stop
