@include('layouts.errors')

<div class="form-item -padded">
    {{ Form::label('contest_id', 'Contest ID:', ['class' => 'field-label']) }}
    {{ Form::text('contest_id', NULL, ['class' => 'text-field']) }}
</div>

<div class="form-item -padded">
    {!! Form::label('signup_start_date', 'Signup Start Date: ', ['class' => 'field-label']) !!}
    {!! Form::date('signup_start_date', (isset($room->signup_start_date)) ? $room->signup_start_date : NULL, ['class' => 'text-field']) !!}
</div>

<div class="form-item -padded">
    {!! Form::label('signup_end_date', 'Signup End Date: ', ['class' => 'field-label']) !!}
    {!! Form::date('signup_end_date', (isset($room->signup_end_date)) ? $room->signup_end_date : NULL, ['class' => 'text-field']) !!}
</div>

<div class="form-item -padded">
    {{ Form::submit('Submit', ['class' => 'button']) }}
</div>
