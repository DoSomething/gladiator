@extends('layouts.master')

@section('main_content')

<div class='container__block'>
    <div class='wrapper'>
        <h1>Create a Waiting Room</h1>
        <hr>
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
                {!! Form::label('start_date', 'Signup Start Date: ', array('class' => 'field-label')) !!}
                {!! Form::date('start_date', NULL, ['class' => 'text-field', 'placeholder' => 'MM/DD/YYYY']) !!}
            </div>

            <div class="form-item">
                {!! Form::label('end_date', 'Signup End Date: ', array('class' => 'field-label')) !!}
                {!! Form::date('end_date', NULL, ['class' => 'text-field', 'placeholder' => 'MM/DD/YYYY']) !!}
            </div>

            <div class="form-item">
                {{ Form::submit('Submit', array('class' => 'button')) }}
            </div>
        {!! Form::close() !!}
    </div>
</div>

@stop
