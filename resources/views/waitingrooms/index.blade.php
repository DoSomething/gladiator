@extends('layouts.master')

@section('main_content')

    @include('layouts.header',[
        'title' => 'Waiting Rooms'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <a class="button" href="{{ route('waitingrooms.create') }}">Add Waiting Room</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                @foreach($rooms as $room)
                    <hr>
                    <div>
                        <h3><a href="{{ route('waitingrooms.show', $room->id) }}">{{ $room->campaign_id }}</a></h3>
                        <div class="container__block message__title">
                            <h4>Signup Dates:</h4>
                            <p>Start Date: {{ $room->signup_start_date }}</p>
                            <p>End Date: {{ $room->signup_end_date }}</p>
                        </div>
                        <div class="container__block message__edit">
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
                @endforeach

            </div>
        </div>
    </div>

@stop
