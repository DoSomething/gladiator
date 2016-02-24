@extends('layouts.master')

@section('title', 'Create a Waiting Room')

@section('main_content')

<div class='container__block'>
    <div class='wrapper'>
        {!! Form::open(array('route' => 'waitingrooms.store')) !!}
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
                {!! Form::date('signup_start_date', NULL, ['class' => 'text-field']) !!}
            </div>

            <div class="form-item">
                {!! Form::label('signup_end_date', 'Signup End Date: ', array('class' => 'field-label')) !!}
                {!! Form::date('signup_end_date', NULL, ['class' => 'text-field']) !!}
            </div>

            <div class="form-item">
                {{ Form::submit('Submit', array('class' => 'button')) }}
            </div>
        {!! Form::close() !!}
    </div>
</div>

@stop
