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
                        <a href="{{ route('export', $room->id) }}" class="button">Export</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

@stop
