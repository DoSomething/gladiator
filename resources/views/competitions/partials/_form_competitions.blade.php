@include('layouts.errors')

<form method="POST" action="{{ route('competitions.update', $competition->id) }}">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}

    <div class="form-item -padded">
        <label class="field-label" for="contest_id">Contest ID:</label>
        <input type="text" name="contest_id" id="contest_id" class="text-field" value="{{ $competition->contest_id or old('contest_id') }}" />
    </div>

    <div class="form-item -padded">
        <label class="field-label" for="competition_start_date">Start Date:</label>
        <input type="date" name="competition_start_date" id="competition_start_date" value={{ $competition->competition_start_date or old('competition_start_date', 'MM/DD/YYYY') }} class="text-field" ></input>
    </div>

    <div class="form-item -padded">
        <label class="field-label" for="competition_end_date">End Date:</label>
        <input type="date" name="competition_end_date" id="competition_end_date" value={{ $competition->competition_end_date or old('competition_end_date', 'MM/DD/YYYY') }} class="text-field" ></input>
    </div>

    <div class="form-item -padded">
        <input type="submit" class="button" value="Submit" />
    </div>
</form>