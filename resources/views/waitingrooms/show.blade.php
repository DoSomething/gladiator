@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Waiting Rooms',
        'subtitle' => 'Viewing waiting room ' . $room->id
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <p>Campaign ID: {{ $room->campaign_id }}</p>
                <p>Campaign Run ID: {{ $room->campaign_run_id }}</p>
                <p>Signup Start Date: {{ $room->signup_start_date }}</p>
                <p>Signup End Date: {{ $room->signup_end_date }}</p>

                @if (hasSignupPeriodEnded($room->signup_end_date))
                    <a href="{{ route('split', $room->id) }}" class="button -secondary">Split room</a>
                @endif

                <ul class="form-actions -inline">
                    <li>
                        <a href="{{ route('waitingrooms.edit', $room->id) }}" class="button">Edit</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

@stop
