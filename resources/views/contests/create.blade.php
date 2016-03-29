@inject('defaultMessage', 'Gladiator\Http\Utilities\DefaultMessage')

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

                    @include('contests.partials._form_contest_messaging', ['default' => $defaultMessage->get('welcome', '1'), 'type' => 'welcome', 'key' => '1'])

                    @include('contests.partials._form_contest_messaging', ['default' => $defaultMessage->get('checkin', '1'), 'type' => 'checkin', 'key' => '1'])

                    @include('contests.partials._form_contest_messaging', ['default' => $defaultMessage->get('reminder', '1'), 'type' => 'reminder', 'key' => '1'])

                    @include('contests.partials._form_contest_messaging', ['default' => $defaultMessage->get('reminder', '2'), 'type' => 'reminder', 'key' => '2'])

                    @include('contests.partials._form_contest_messaging', ['default' => $defaultMessage->get('reminder', '3'), 'type' => 'reminder', 'key' => '3'])

                    @include('contests.partials._form_contest_messaging', ['default' => $defaultMessage->get('reminder', '4'), 'type' => 'reminder', 'key' => '4'])

                    @include('contests.partials._form_contest_messaging', ['default' => $defaultMessage->get('reminder', '5'), 'type' => 'reminder', 'key' => '5'])

                    @include('contests.partials._form_contest_messaging', ['default' => $defaultMessage->get('leaderboard', '1'), 'type' => 'leaderboard', 'key' => '1'])

                    @include('contests.partials._form_contest_messaging', ['default' => $defaultMessage->get('leaderboard', '2'), 'type' => 'leaderboard', 'key' => '2'])

                    <input type="submit" class="button" value="Submit" />
                </form>
            </div>
        </div>
    </div>

@stop
