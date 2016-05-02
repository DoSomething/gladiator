@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Contests',
        'subtitle' => 'Viewing contest ID: ' . $contest->id
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block -half">
                <ul>
                    <li><strong>Campaign:</strong> {{ $contest->campaign->title or 'No title available' }}</li>
                    <li><strong>Campaign Run ID:</strong> {{ $contest->campaign_run_id }}</li>
                </ul>
            </div>

            <div class="container__block -half">
                <ul class="form-actions -inline">
                    <li>
                        <a href="{{ route('contests.edit', $contest->id) }}" class="button">Edit</a>
                    </li>
                    <li>
                        <a href="{{ route('split', $contest->waitingRoom->id) }}" class="button">Split</a>
                    </li>
                    <li>
                        <a href="{{ route('contests.user.add', $contest->id) }}" class="button">Signup User</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
            <h2 class="heading">Data export</h1>
                <ul class="list">
                    <li><a href="{{ route('contests.export', $contest->id) }}">&DownArrowBar; Export</a> &mdash; CSV list of users for this contest</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <h2 class="heading -alpha">Messaging</h2>
                <p>The current name of the messages sender is: <em>{{ $contest->sender_name or 'not assigned' }}</em></p>
                <p>The current email assigned for the messages sender is: <em>{{ $contest->sender_email or 'not assigned' }}</em></p>
                <p><a href="{{ route('contests.messages.edit', $contest->id) }}" class="button -secondary">View &amp; Edit Messages</a></p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <h2 class="heading -alpha">Waiting Room</h2>
                <p>The waiting room for this contest currently contains <strong>{{ $contest->waitingRoom->users->count() }}</strong> {{ $contest->waitingRoom->users->count() === 1 ? 'contestant' : 'contestants'  }}.</p>

                <p><a href="{{ route('waitingrooms.show', $contest->waitingRoom->id) }}" class="button -secondary">View Waiting Room</a></p>
            </div>
        </div>
    </div>

    @if ($contest->competitions->count())
    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <h2 class="heading -alpha">Competitions</h2>

                <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr class="table__header">
                          <th class="table__cell">Competition ID</th>
                          <th class="table__cell">Start Date</th>
                          <th class="table__cell">End Date</th>
                          <th class="table__cell"># of Contestants</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($contest->competitions as $competition)
                            <tr class="table__row">
                                <td class="table__cell"><a href="{{ route('competitions.show', $competition->id) }}">{{ $competition->id }}</a></td>
                                <td class="table__cell">{{ $competition->competition_start_date->format('F d, Y') }}</td>
                                <td class="table__cell">{{ $competition->competition_end_date->format('F d, Y') }}</td>
                                <td class="table__cell">{{ $competition->users->count() }}</td>
                            </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

@stop
