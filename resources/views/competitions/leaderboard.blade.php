@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Competitions',
        'subtitle' => 'Viewing competition ' . $competition->id
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <h2 class="heading -banner">Leaderboard</h2>

                <table class="table">
                    <thead>
                        <tr class="table__header">
                            <th class="table__cell">Rank</th>
                            <th class="table__cell">Name</th>
                            <th class="table__cell">Quantity</th>
                            <th class="table__cell">Email</th>
                            <th class="table__cell">Flagged</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leaderboard as $index => $user)
                            <tr class="table__row">
                                <td class="table__cell">{{ $user['rank'] }}</td>
                                <td class="table__cell"><a href="{{ route('users.show', $user['user']->id) }}">{{ $user['user']->first_name or 'Anonymous' }} {{ $user['user']->last_name or '' }}</a></td>
                                <td class="table__cell">{{ $user['quantity'] or '' }}</td>
                                <td class="table__cell">{{ $user['user']->email or '' }}</td>
                                <td class="table__cell">{{ $user['flagged'] or '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
