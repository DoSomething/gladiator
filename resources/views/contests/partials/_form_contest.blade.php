<div class="form-item -padded">
    <label class="field-label" for="signup_start_date">Signup Start Date:</label>
    <input type="date" name="signup_start_date" id="signup_start_date" class="text-field" value="{{ $contest->waitingRoom->signup_start_date or old('signup_start_date', 'MM/DD/YYYY') }}"></input>
</div>

<div class="form-item -padded">
    <label class="field-label" for="signup_end_date">Signup End Date:</label>
    <input type="date" name="signup_end_date" id="signup_end_date"  class="text-field" value="{{ $contest->waitingRoom->signup_end_date or old('signup_end_date', 'MM/DD/YYYY') }}"></input>
</div>

<div class="form-item -padded">
    <label class="field-label" for="id">Campaign ID:</label>
    <input type="number" name="campaign_id" id="campaign_id" class="text-field" placeholder="1234" value="{{ $contest->campaign_id or old('campaign_id') }}"/>
</div>

<div class="form-item -padded">
    <label class="field-label" for="id">Campaign Run ID:</label>
    <input type="number" name="campaign_run_id" id="campaign_run_id" class="text-field" placeholder="42" value="{{ $contest->campaign_run_id or old('campaign_run_id') }}"/>
</div>

<div class="form-item -padded">
    <label class="field-label" for="sender">Messages Sender:</label>
    <input type="text" name="sender" id="sender" class="text-field" placeholder="kallark&#64;dosomething.org" value="{{ $contest->sender or old('sender') }}" />
</div>
