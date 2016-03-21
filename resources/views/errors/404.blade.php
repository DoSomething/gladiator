@extends('layouts.master')

@section('main_content')

    @include('layouts.header',[
        'title' => '404'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <p>Sorry, that resource was not found.</p>
            </div>
        </div>
    </div>

@stop
