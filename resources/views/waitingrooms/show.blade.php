@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Waiting Rooms',
        'subtitle' => 'Viewing waiting room ' . $room->id
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <p>Contest ID: {{ $room->contest_id }}</p>
                <p>Campaign ID: {{ $contest->campaign_id }}</p>
                <p>Campaign Run ID: {{ $contest->campaign_run_id }}</p>
                <p>Signup Start Date: {{ $room->signup_start_date->format('F d, Y') }}</p>
                <p>Signup End Date: {{ $room->signup_end_date->format('F d, Y') }}</p>

                <ul class="form-actions -inline">
                    @if (hasSignupPeriodEnded($room->signup_end_date))
                        <li>
                            <a href="{{ route('split', $room->id) }}" class="button -secondary">Split room</a>
                        </li>
                    @endif

                    <li>
                        <a href="{{ route('waitingrooms.edit', $room->id) }}" class="button">Edit</a>
                    </li>
                    <li>
                        <a href="{{ route('waitingrooms.export', $room->id) }}" class="button">Export</a>
                    </li>
                </ul>
            </div>

            <div class="container__block">
                <table class="table">
                    <thead>
                        <tr class="table__header">
                            <th class="table__cell">First Name</th>
                            <th class="table__cell">Email</th>
                            <th class="table__cell">Phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $key => $user)
                            @if ($user)
                                <tr class="table__row">
                                    <td class="table__cell"><a href="{{ route('users.show', $user->id) }}">{{ $user->first_name or $user->id }}</td>
                                    <td class="table__cell">{{ $user->email or NULL }}</td>
                                    <td class="table__cell">{{ $user->mobile or NULL }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop
