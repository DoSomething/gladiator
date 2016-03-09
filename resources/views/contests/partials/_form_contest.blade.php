@include('layouts.errors')

<div class="form-item -padded">
    {!! Form::label('campaign_id', 'Campaign ID:', ['class' => 'field-label']) !!}
    {!! Form::text('campaign_id', old('campaign_id'), ['class' => 'text-field']) !!}
</div>

<div class="form-item -padded">
    {!! Form::label('campaign_run_id', 'Run ID:', ['class' => 'field-label']) !!}
    {!! Form::text('campaign_run_id', old('campaign_run_id'), ['class' => 'text-field']) !!}
</div>

<div class="form-item -padded">
    {!! Form::label('duration', 'Duration (in days):', ['class' => 'field-label']) !!}
    {!! Form::number('duration', old('duration'), ['class' => 'text-field']) !!}
</div>

<div class="form-item -padded">
    {!! Form::submit('Submit', ['class' => 'button']) !!}
</div>
