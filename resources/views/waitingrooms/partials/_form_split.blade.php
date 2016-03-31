<form method="POST" action="{{ route('split', $room->id) }}">
    {{ method_field('POST') }}
    {{ csrf_field() }}

    <div class="container__block">
        <div class="form-item -padded">
            <div class="form-item -padded">
                <label class="field-label" for="competition_end_date">End date for these competitions:</label>
                <input type="date" name="competition_end_date" id="competition_end_date" value='MM/DD/YYYY' class="text-field"></input>
            </div>
            <div class="form-item -padded">
                <label class="field-label" for="leaderboard_msg_day">Send leaderboard message on:</label>
                <div class="select">
                    <select name="leaderboard_msg_day">
                        <option value="0">Monday</option>
                        <option value="1">Tuesday</option>
                        <option value="2">Wednesday</option>
                        <option value="3">Thursday</option>
                        <option value="4">Friday</option>
                        <option value="5">Saturday</option>
                        <option value="6">Sunday</option>
                    </select>
                </div>
            </div>
        </div>

        <input type="submit" class="button" value="Split" />
    </div>
</form>