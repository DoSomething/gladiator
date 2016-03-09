@include('layouts.errors')

<div class="form-item -padded">
    {!! Form::label('campaign_id', 'Campaign ID:', ['class' => 'field-label']) !!}
    {!! Form::text('campaign_id', (isset($contest->campaign_id)) ? $contest->campaign_id : NULL, ['class' => 'text-field']) !!}
</div>

<div class="form-item -padded">
    {!! Form::label('campaign_run_id', 'Run ID:', ['class' => 'field-label']) !!}
    {!! Form::text('campaign_run_id', (isset($contest->campaign_run_id)) ? $contest->campaign_run_id : NULL, ['class' => 'text-field']) !!}
</div>

<div class="form-item -padded">
    {!! Form::label('duration', 'Duration (in days):', ['class' => 'field-label']) !!}
    {!! Form::number('duration', (isset($contest->duration)) ? $contest->duration : NULL, ['class' => 'text-field']) !!}
</div>

<div class="form-item -padded">
    {!! Form::submit('Submit', ['class' => 'button']) !!}
</div>
