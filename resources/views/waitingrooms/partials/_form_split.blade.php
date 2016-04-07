<form method="POST" action="{{ route('split', $room->id) }}">
    {{ method_field('POST') }}
    {{ csrf_field() }}

    <div class="container__block">
        <div class="form-item -padded">
            <div class="form-item -padded">
                <label class="field-label" for="competition_end_date">End date for these competitions:</label>
                <input type="date" name="competition_end_date" id="competition_end_date" value='MM/DD/YYYY' class="text-field"></input>
            </div>

            @include('competitions.partials._form_leaderboard_msg_day_field', [
                'default' => null,
            ])
        </div>

        <input type="submit" class="button" value="Split" />
    </div>
</form>