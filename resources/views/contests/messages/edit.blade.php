@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Messages',
        'subtitle' => 'View messages for contest ID: ' . $contest->id,
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block -narrow">
                <form method="POST" action="{{ route('contests.messages.update', $contest->id) }}">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}

                    @include('layouts.errors')

                    <h2 class="heading -alpha">Edit Messages</h2>

                    @foreach ($contest->messages as $message)

                        @include('contests.partials._form_contest_messaging', ['message' => $message])

                    @endforeach

                    <input type="submit" class="button" value="Submit" />
                </form>
            </div>
        </div>
    </div>

@stop
