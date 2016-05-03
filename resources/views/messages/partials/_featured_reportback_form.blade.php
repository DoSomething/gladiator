@include('layouts.errors')

<form method="POST" action="{{ route('competitions.message.updateFeaturedReportback', $competition->id) }}">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}

    <div class="form-item -padded">
        <label class="field-label" for="contest_id">Reportback ID:</label>
        <input type="text" name="reportback_id" id="reportback_id" class="text-field" value="{{ $competition->reportback_id or old('reportback_id') }}" />
    </div>

    <div class="form-item -padded">
        <label class="field-label" for="contest_id">Reportback Item ID:</label>
        <input type="text" name="reportback_item_id" id="reportback_item_id" class="text-field" value="{{ $competition->reportback_item_id or old('reportback_item_id') }}" />
    </div>

    <div class="form-item -padded">
        <label class="field-label" for="contest_id">Shoutout:</label>
        <input type="text" name="shoutout" id="shoutout" class="text-field" value="{{ $competition->shoutout or old('shoutout') }}" />
    </div>

    <div class="form-item -padded">
        <input type="submit" class="button" value="Submit" />
    </div>
</form>
