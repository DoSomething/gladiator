@extends('layouts.master')

@section('title', 'Waiting Room ' . $room->id)

@section('main_content')

<div class='container__block'>
    <div class='wrapper'>
        <p>Campaign ID: {{ $room->campaign_id }}</p>
        <p>Campaign Run ID: {{ $room->campaign_run_id }}</p>
        <p>Signup Start Date: {{ $room->signup_start_date }}</p>
        <p>Signup End Date: {{ $room->signup_end_date }}</p>
    </div>
</div>

<ul class="form-actions -inline">
    <li>
        {!! Form::open(['method' => 'DELETE','route' => ['waitingrooms.destroy', $room->id]]) !!}
        {!! Form::submit('Delete', array('class' => 'button delete')) !!}
        {!! Form::close() !!}
    </li>
    <li>
        <a href="{{ route('waitingrooms.edit', $room->id) }}" class="button">Edit</a>
    </li>
</ul>

@stop
