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

                    @include('contests.partials._form_contest_messaging', ['type' => 'welcome', 'name' => 'general'])

                    @include('contests.partials._form_contest_messaging', ['type' => 'reminder', 'name' => 'first'])

                    @include('contests.partials._form_contest_messaging', ['type' => 'reminder', 'name' => 'general_v1'])

                    @include('contests.partials._form_contest_messaging', ['type' => 'reminder', 'name' => 'general_v2'])

                    @include('contests.partials._form_contest_messaging', ['type' => 'reminder', 'name' => 'last'])

                    @include('contests.partials._form_contest_messaging', ['type' => 'general', 'name' => 'checkin'])

                    @include('contests.partials._form_contest_messaging', ['type' => 'leaderboard', 'name' => 'update'])

                    @include('contests.partials._form_contest_messaging', ['type' => 'leaderboard', 'name' => 'final'])


                    <input type="submit" class="button" value="Submit" />
                </form>
            </div>
        </div>
    </div>

@stop
