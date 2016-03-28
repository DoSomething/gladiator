@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Contests',
        'subtitle' => 'Add a new contest'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block -narrow">
                <form method="POST" action="{{ route('contests.store') }}">
                    {{ csrf_field() }}

                    <h2 class="heading -alpha">Settings</h2>

                    @include('contests.partials._form_contest')


                    <h2 class="heading -alpha">Messaging Settings</h2>

                    @include('contests.partials._form_contest_messaging', ['type' => 'welcome', 'key' => '1', 'label' => 'Welcome'])

                    @include('contests.partials._form_contest_messaging', ['type' => 'checkin', 'key' => '1', 'label' => 'Where are you? Check status'])

                    @include('contests.partials._form_contest_messaging', ['type' => 'reminder', 'key' => '1', 'label' => 'Reminder for first submission due'])

                    @include('contests.partials._form_contest_messaging', ['type' => 'reminder', 'key' => '2', 'label' => 'Reminder to submit v1'])

                    @include('contests.partials._form_contest_messaging', ['type' => 'reminder', 'key' => '3', 'label' => 'Reminder to submit v2'])

                    @include('contests.partials._form_contest_messaging', ['type' => 'reminder', 'key' => '4', 'label' => 'Last minute reminder v1'])

                    @include('contests.partials._form_contest_messaging', ['type' => 'reminder', 'key' => '5', 'label' => 'Last minute reminder v2'])

                    @include('contests.partials._form_contest_messaging', ['type' => 'leaderboard', 'key' => '1', 'label' => 'Leaderboard update'])

                    @include('contests.partials._form_contest_messaging', ['type' => 'leaderboard', 'key' => '2', 'label' => 'Final leaderboard update'])

                    <input type="submit" class="button" value="Submit" />
                </form>
            </div>
        </div>
    </div>

@stop
