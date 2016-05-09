<form method="POST" action="{{ route('split', $room->id) }}">
    @include('layouts.errors')

    {{ csrf_field() }}

    <div class="container__block">
        <div class="form-item -padded">
            <label class="field-label" for="competition_end_date">End date for these competitions:</label>
            <input type="date" name="competition_end_date" id="competition_end_date" class="text-field" value="{{ format_date_form_field($room, 'competition_end_date') }}"></input>
        </div>

        <div class="form-item -padded">
            <label class="field-label" for="id">Max users per competition:</label>
            <input type="number" name="competition_max" id="competition_max" class="text-field" data-total="{{count($room->users)}}" placeholder=300 value="{{ old('competition_max') }}" />
        </div>

        <div class="form-item -padded">
            <label class="field-label" for="rules_url">Rules URL:</label>
            <input type="text" name="rules_url" id="rules_url" class="text-field" placeholder="http://docs.google.com/the-rules" value="{{ old('rules_url') }}" />
        </div>

        @include('competitions.partials._form_leaderboard_msg_day_field', [ 'default' => null ])

        <input type="submit" class="button" value="Split" />
    </div>
</form>
