<form method="POST" action="{{ route('split', $room->id) }}">
    {{ method_field('POST') }}
    {{ csrf_field() }}

    <div class="container__block">
        <div class="form-item -padded">
            <label class="field-label" for="competition_end_date">End date for these competitions:</label>
            <input type="date" name="competition_end_date" id="competition_end_date" value='MM/DD/YYYY' class="text-field"></input>
        </div>

        <div class="form-item -padded">
            <label class="field-label" for="id">Max users per competition:</label>
            <input type="number" name="competition_max" id="competition_max" class="text-field" value="300"/>
        </div>

        @include('competitions.partials._form_leaderboard_msg_day_field', [
            'default' => null,
        ])

        <input type="submit" class="button" value="Split" />
    </div>
</form>
