@extends('layouts.master')

@section('title', 'Edit Waiting Room ' . $room->id)

@section('main_content')

<div class='container__block'>
    <div class='wrapper'>
        {!! Form::model($room, ['method' => 'PATCH','route' => ['waitingrooms.update', $room->id]]) !!}
            <div class="form-item">
                {{ Form::label('campaign_id', 'Campaign ID (node id):', array('class' => 'field-label')) }}
                {{ Form::text('campaign_id', NULL, array('class' => 'text-field')) }}
            </div>

            <div class="form-item">
                {{ Form::label('campaign_run_id', 'Campaign Run ID:', array('class' => 'field-label')) }}
                {{ Form::text('campaign_run_id', NULL, array('class' => 'text-field')) }}
            </div>

            <div class="form-item">
                {!! Form::label('signup_start_date', 'Signup Start Date: ', array('class' => 'field-label')) !!}
                {!! Form::date('signup_start_date', $room->signup_start_date, ['class' => 'text-field']) !!}
            </div>

            <div class="form-item">
                {!! Form::label('signup_end_date', 'Signup End Date: ', array('class' => 'field-label')) !!}
                {!! Form::date('signup_end_date', $room->signup_end_date, ['class' => 'text-field']) !!}
            </div>

            {!! Form::submit('Update Message', ['class' => 'button']) !!}

        {!! Form::close() !!}
    </div>
</div>

@stop
