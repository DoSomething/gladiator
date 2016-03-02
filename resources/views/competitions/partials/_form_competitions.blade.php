@include('layouts.errors')

<div class="form-item -padded">
    {!! Form::label('campaign_id', 'Campaign ID:', ['class' => 'field-label']) !!}
    {!! Form::text('campaign_id', (isset($room->campaign_id)) ? $room->campaign_id : NULL, ['class' => 'text-field']) !!}
</div>

<div class="form-item -padded">
    {!! Form::label('campaign_run_id', 'Run ID:', ['class' => 'field-label']) !!}
    {!! Form::text('campaign_run_id', (isset($room->campaign_run_id)) ? $room->campaign_run_id : NULL, ['class' => 'text-field']) !!}
</div>

<div class="form-item -padded">
    {!! Form::label('start_date', 'Start date:', ['class' => 'field-label']) !!}
    {!! Form::date('start_date', (isset($competition->start_date)) ? $competition->start_date : NULL, ['class' => 'text-field']) !!}
</div>

<div class="form-item -padded">
    {!! Form::label('end_date', 'End date:', ['class' => 'field-label']) !!}
    {!! Form::date('end_date', (isset($competition->end_date)) ? $competition->end_date : NULL, ['class' => 'text-field']) !!}
</div>

<div class="form-item -padded">
    {!! Form::submit('Submit', ['class' => 'button']) !!}
</div>
