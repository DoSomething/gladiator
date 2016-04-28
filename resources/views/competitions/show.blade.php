@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Competitions',
        'subtitle' => 'Viewing competition ' . $competition->id
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block -half">
                <h2 class="heading">Information</h2>

                <ul>
                    <li><strong>Campaign:</strong> {{ $competition->contest->campaign->title or 'No title available' }}</li>
                    <li><strong>Campaign Run ID:</strong> {{ $competition->contest->campaign_run_id }}</li>
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
                        <a href="{{ route('competitions.message', ['competition' => $competition->id,'contest' => $competition->contest->id]) }}" class="button">Email</a>
                    </li>
                    <li>
                        <a href="{{ route('competitions.leaderboard', ['competition' => $competition->id]) }}" class="button">Leaderboard</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="wrapper">
            <div class="container__block -half">
                <h2 class="heading">Statistics</h2>
                <ul class="list">
                    <li>Total number of contestants in competition: {{ $statistics->totalContestants }}</li>
                    <li>Number of contestants who have reported back: {{ $statistics->totalReportbacks }}</li>
                    <li>Reportback rate: {{ $statistics->reportbackRate . '%' }}</li>
                </ul>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="wrapper">
            <div class="container__block">
            <h2 class="heading">Data export</h1>
                <ul class="list">
                    <li><a href="{{ route('competitions.export', ['competition' => $competition->id]) }}">&DownArrowBar; Export</a> &mdash; CSV list of users for this competition</li>
                </ul>
            </div>
        </div>
    </div>


    @include('users.partials._table_users', ['users' => $competition->contestants, 'role' => 'Contestants: ' . $competition->contestants->count()])

@stop
