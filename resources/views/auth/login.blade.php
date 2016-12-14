@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Gladiator',
        'subtitle' => 'Please login to continue.'
    ])

    <div class="container -padded">
        <div class="wrapper">
            <div class="container__block -narrow">
                <p>
                    Welcome to <strong>Gladiator</strong>, our contest activity admin tool.
                </p>

                <p>
                    <a href="/login" class="button">Log In</a>
                </p>
        </div>
    </div>

@stop
