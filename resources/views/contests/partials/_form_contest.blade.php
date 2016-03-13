@include('layouts.errors')

{{ csrf_field() }}

<div class="form-item -padded">
    <label class="field-label" for="id">Campaign ID:</label>
    <input type="number" name="campaign_id" id="campaign_id" class="text-field" placeholder="1234" value="{{ $contest->campaign_id or old('campaign_id') }}"/>
</div>

<div class="form-item -padded">
    <label class="field-label" for="id">Campaign Run ID:</label>
    <input type="number" name="campaign_run_id" id="campaign_run_id" class="text-field" placeholder="42" value="{{ $contest->campaign_run_id or old('campaign_run_id') }}"/>
</div>

<div class="form-item -padded">
    <label class="field-label" for="id">Duration (in days):</label>
    <input type="number" name="duration" id="duration" class="text-field" placeholder="1" value="{{ $contest->duration or old('duration') }}"/>
</div>

<input type="submit" class="button" value="Submit" />
