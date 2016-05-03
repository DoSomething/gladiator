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

                    @include('layouts.errors')

                    <h2 class="heading -alpha">Settings</h2>

                    @include('contests.partials._form_contest')


                    <h2 class="heading -alpha">Messages</h2>

                    @foreach ($messages as $message)

                        @include('contests.partials._form_contest_messaging', ['message' => $message])

                    @endforeach

                    <input type="submit" class="button" value="Submit" />
                </form>
            </div>
        </div>
    </div>

@stop
