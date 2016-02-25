@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Waiting Rooms',
        'subtitle' => 'Edit waiting room ' . $room->id
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block -narrow">
                {!! Form::model($room, ['method' => 'PATCH','route' => ['waitingrooms.update', $room->id]]) !!}

                    @include('waitingrooms.partials._form_waitingrooms')

                {!! Form::close() !!}
            </div>
        </div>
    </div>

@stop
