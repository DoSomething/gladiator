@extends('layouts.master')

@section('main_content')

    <h1>Create A New Competition</h1>

    <div class='container__block'>
        <div class='wrapper'>
            {!! Form::open(array('route' => 'competitions.store')) !!}
                <div class="form-item">
                    {{ Form::label('campaign_id', 'Campaign ID:', array('class' => 'field-label')) }}
                    {{ Form::text('campaign_id', NULL, array('class' => 'text-field')) }}
                </div>

                <div class="form-item">
                    {{ Form::label('campaign_run_id', 'Run ID:', array('class' => 'field-label')) }}
                    {{ Form::text('campaign_run_id', NULL, array('class' => 'text-field')) }}
                </div>

                <div class="form-item">
                    {{ Form::label('start_date', 'Start date:', array('class' => 'field-label')) }}
                    {{ Form::input('date', 'start_date', NULL, array('class' => 'text-field')) }}
                </div>

                <div class="form-item">
                    {{ Form::label('end_date', 'End date:', array('class' => 'field-label')) }}
                    {{ Form::input('date', 'end_date', NULL, array('class' => 'text-field')) }}
                </div>

                <div class="form-item">
                    {{ Form::submit('Submit', array('class' => 'button')) }}
                </div>
            {!! Form::close() !!}
        </div>
    </div>

@stop
