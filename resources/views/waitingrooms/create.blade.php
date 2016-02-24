@extends('layouts.master')

@section('title', 'Create a Waiting Room')

@section('main_content')

<div class='container__block'>
    <div class='wrapper'>
        {!! Form::open(array('route' => 'waitingrooms.store')) !!}
            @include('waitingrooms.partials._form_waitingrooms')
        {!! Form::close() !!}
    </div>
</div>

@stop
