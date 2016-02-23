@extends('layouts.master')

@section('main_content')

    <h1>Edit Competition</h1>

    <div class='container__block'>
      <div class='wrapper'>
        {!! Form::open(['method' => 'PATCH', 'route' => ['competitions.update', $competition->id]]) !!}
            <div class="form-item">
                {{ Form::label('campaign_id', 'Campaign ID:', ['class' => 'field-label']) }}
                {{ Form::text('campaign_id', $competition->campaign_id, ['class' => 'text-field']) }}
            </div>

            <div class="form-item">
                {{ Form::label('campaign_run_id', 'Run ID:', ['class' => 'field-label']) }}
                {{ Form::text('campaign_run_id', $competition->campaign_run_id, ['class' => 'text-field']) }}
            </div>

            <div class="form-item">
                {{ Form::label('start_date', 'Start date:', ['class' => 'field-label']) }}
                {{ Form::input('date', 'start_date', NULL, ['class' => 'text-field']) }}
            </div>

            <div class="form-item">
                {{ Form::label('end_date', 'End date:', ['class' => 'field-label']) }}
                {{ Form::input('date', 'end_date', NULL, ['class' => 'text-field']) }}
            </div>

            <div class="form-item">
                {{ Form::submit('Submit', ['class' => 'button']) }}
            </div>
        {!! Form::close() !!}
      </div>
    </div>

@stop
