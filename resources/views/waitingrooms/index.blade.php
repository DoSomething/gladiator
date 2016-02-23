@extends('layouts.master')

@section('main_content')

@foreach($rooms as $room)
    <div>
        <h3><a href="{{ route('waitingrooms.show', $room->id) }}">{{ $room->campaign_id }}</a></h3>
        <div class="container__block -half message__title">
            <h4>Signup Dates:</h4>
            <p>Start Date: {{ $room->signup_start_date }}</p>
            <p>End Date: {{ $room->signup_end_date }}</p>
        </div>
        <div class="container__block -half message__edit">
            <ul class="form-actions -inline">
                <li>
                    {!! Form::open(['method' => 'DELETE','route' => ['waitingrooms.destroy', $room->id]]) !!}
                    {!! Form::submit('Delete', array('class' => 'button -secondary delete')) !!}
                    {!! Form::close() !!}
                </li>
                <li>
                    <a href="{{ route('waitingrooms.edit', $room->id) }}" class="button -secondary">Edit room</a>
                </li>
            </ul>
        </div>
    </div>
    <hr>
@endforeach

@stop
