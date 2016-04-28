@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Competitions',
        'subtitle' => 'Viewing leaderboard for competition ' . $competition->id
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
            <h2 class="heading">Data export</h1>
                <ul class="list">
                    <li><a href="{{ route('competitions.export', ['competition' => $competition->id, 'withReportback' => 'true']) }}">&DownArrowBar; Export</a> &mdash; CSV list of users and their activity in this leaderboard</li>
                </ul>
            </div>
        </div>
    </div>

    @if (count($leaderboard))
        @include('competitions.partials._table_users_leaderboard', ['leaderboard' => $leaderboard])
    @endif

    @if (count($flagged))
        @include('competitions.partials._table_users_flagged', ['flagged' => $flagged])
    @endif

    @if (count($pending))
        @include('competitions.partials._table_users_pending', ['pending' => $pending])
    @endif
@stop
