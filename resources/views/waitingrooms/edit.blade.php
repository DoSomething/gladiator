@extends('layouts.master')

@section('title', 'Edit Waiting Room ' . $room->id)

@section('main_content')

<div class='container__block'>
    <div class='wrapper'>
        {!! Form::model($room, ['method' => 'PATCH','route' => ['waitingrooms.update', $room->id]]) !!}
            @include('waitingrooms.partials._form_waitingrooms')
        {!! Form::close() !!}
    </div>
</div>

@stop
