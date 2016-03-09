@include('layouts.errors')

<div class="form-item -padded">
    {!! Form::label('contest_id', 'Contest ID:', ['class' => 'field-label']) !!}
    {!! Form::text('contest_id', $competition->contest_id or old($competition->contest_id), ['class' => 'text-field']) !!}
</div>

<div class="form-item -padded">
    {!! Form::label('competition_start_date', 'End date:', ['class' => 'field-label']) !!}
    {!! Form::date('competition_start_date', (isset($competition->competition_start_date)) ? $competition->competition_start_date : NULL, ['class' => 'text-field']) !!}
</div>

<div class="form-item -padded">
    {!! Form::label('competition_end_date', 'End date:', ['class' => 'field-label']) !!}
    {!! Form::date('competition_end_date', (isset($competition->competition_end_date)) ? $competition->competition_end_date : NULL, ['class' => 'text-field']) !!}
</div>

<div class="form-item -padded">
    {!! Form::submit('Submit', ['class' => 'button']) !!}
</div>
