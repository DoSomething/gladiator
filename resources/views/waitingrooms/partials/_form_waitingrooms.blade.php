{{ csrf_field() }}

@include('layouts.errors')

<div class="form-item -padded">
    <label for="contest_id" class="field-label">Contest ID:</label>
    <input type="number" name="contest_id" id="contest_id" class="text-field" readonly value="{{ $room->contest_id or old('contest_id') }}"></input>
</div>

<div class="form-item -padded">
    <label for="signup_start_date" class="field-label">Signup Start Date:</label>
    <input type="date" name="signup_start_date" id="signup_start_date" class="text-field" value="{{ isset($room) ? format_date_form_field($room, 'signup_start_date') : '' }}" />
</div>

<div class="form-item -padded">
    <label for="signup_end_date" class="field-label">Signup End Date:</label>
    <input type="date" name="signup_end_date" id="signup_end_date" class="text-field" value="{{ isset($room) ? format_date_form_field($room, 'signup_end_date') : '' }}" />
</div>

<div class="form-item -padded">
    <input type="submit" value="Submit" class="button" />
</div>
