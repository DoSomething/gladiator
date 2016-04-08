@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Competitions',
        'subtitle' => 'Viewing competition ' . $competition->id
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block -half">
                <ul>
                    <li><strong>Campaign:</strong> {{ $contest->campaign->title or 'No title available' }}</li>
                    <li><strong>Campaign Run ID:</strong> {{ $contest->campaign_run_id }}</li>
                    <li><strong>Contest ID:</strong> <a href="{{ route('contests.show', $competition->contest_id) }}">{{ $competition->contest_id }}</a></li>
                    <li><strong>Start Date:</strong> {{ $competition->competition_start_date->format('F d, Y') }}</li>
                    <li><strong>End Date:</strong> {{ $competition->competition_end_date->format('F d, Y') }}</li>
                    <li><strong>Leaderboard Message Sends:</strong> {{ get_day_of_week($competition->leaderboard_msg_day) }}</li>
                </ul>
            </div>
            <div class="container__block -half">
                <ul class="form-actions -inline">
                    <li>
                        <a href="{{ route('competitions.edit', $competition->id) }}" class="button">Edit</a>
                    </li>
                    <li>
                        <a href="{{ route('competitions.export', $competition->id) }}" class="button">Export</a>
                    </li>
                    <li>
                        <a href="{{ route('competitions.message', ['competition' => $competition->id,'contest' => $contest->id]) }}" class="button">Email</a>
                    </li>

                </ul>
            </div>
        </div>
    </div>

    @include('users.partials._table_users', ['users' => $users, 'role' => 'Contestants: ' . $competition->users->count()])
@stop
