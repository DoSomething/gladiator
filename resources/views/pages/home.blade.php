@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Gladiator'
    ])

    <div class="container -padded">
        <div class="wrapper">
            <div class="container__block -narrow">
                <p>Welcome to Gladiator! DoSomething.org's competition admin tool.</p>

                <p>
                    <a href="/login" class="button">Log In</a>
                </p>
            </div>
        </div>
    </div>

@stop
