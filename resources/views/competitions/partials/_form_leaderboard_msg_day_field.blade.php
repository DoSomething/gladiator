<div class="form-item -padded">
    <label class="field-label" for="leaderboard_msg_day">Send leaderboard message on:</label>
    <div class="select">
        <select name="leaderboard_msg_day">
            @for ($i = 0; $i <= 6; $i++)
                <option value="{{ $i }}" @if($default === $i) selected @endif>
                    {{ jddayofweek($i, 1) }}
                </option>
            @endfor
        </select>
    </div>
</div>
