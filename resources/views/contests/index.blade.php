@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Contests'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block -narrow">
                <a class="button" href="{{ route('contests.create') }}">Add Contest</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr class="table__header">
                                <th class="table__cell">ID</th>
                                <th class="table__cell">Campaign</th>
                                <th class="table__cell">Campaign Run</th>
                                <th class="table__cell">Signup End Date</th>
                                <th class="table__cell">Signups</th>
                                <th class="table__cell">Waiting Room Status</th>
                                <th class="table__cell">Competitions</th>
                            </tr>
                        </thead>
                        <tbody>


                            @foreach($contests as $contest)
                                <tr class="table__row">
                                    <td class="table__cell"><a href="{{ route('contests.show', $contest->id) }}">{{ $contest->id }}</a></td>
                                    <td class="table__cell"><a href="{{ url(config('services.phoenix.uri') .'/node/' . $contest->campaign_id) }}" target="_blank">{{ $contest->campaign->title or 'No title available' }}</a></td>
                                    <td class="table__cell">{{ $contest->campaign_run_id }}</td>
                                    <td class="table__cell">{{ $contest->waitingRoom->signup_end_date->format('F d, Y') }}</td>
                                    <td class="table__cell"><a href="{{ route('waitingrooms.show', $contest->waitingroom->id) }}">{{ $contest->waitingroom->users->count() }}</a></td>
                                    <td class="table__cell">
                                        <span class="status {{ ($contest->waitingRoom->isOpen()) ? '-open' : '-closed' }}">
                                            {{ ($contest->waitingRoom->isOpen()) ? 'Open' : 'Closed' }}
                                        </span>
                                    </td>
                                    <td class="table__cell">{{ $contest->competitions->count() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
