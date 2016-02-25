@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Waiting Rooms',
        'subtitle' => 'Add a new waiting room'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block -narrow">
                {!! Form::open(['route' => 'waitingrooms.store']) !!}

                    @include('waitingrooms.partials._form_waitingrooms')

                {!! Form::close() !!}
            </div>
        </div>
    </div>

@stop
