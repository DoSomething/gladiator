<fieldset>
    <h3 id={{ $message['type'] . $message['key'] }} class="heading">{{ $message['label'] }} email:</h3>

    <div class="form-item -padded">
        <label class="field-label" for="{{ correspondence()->getAttribute($message, 'subject') }}">Subject:</label>
        <input class="text-field" type="text" name="{{ correspondence()->getAttribute($message, 'subject') }}" id="{{ correspondence()->getAttribute($message, 'subject') }}" value="{{ correspondence($message, 'subject') }}" />
    </div>

    <div class="form-item -padded">
        <label class="field-label" for="{{ correspondence()->getAttribute($message, 'body') }}">Body:</label>
        <textarea class="text-field" name="{{ correspondence()->getAttribute($message, 'body') }}" id="{{ correspondence()->getAttribute($message, 'body') }}" rows="10">{{ correspondence($message, 'body') }}</textarea>
    </div>

    @if ($message['type'] === 'leaderboard')
        <div class="form-item -padded">
            <label class="field-label" for="{{ correspondence()->getAttribute($message, 'pro_tip') }}">Pro Tip:</label>
            <textarea class="text-field" name="{{ correspondence()->getAttribute($message, 'pro_tip') }}" id="{{ correspondence()->getAttribute($message, 'pro_tip') }}" rows="3">{{ correspondence($message, 'pro_tip') }}</textarea>
        </div>

        <div class="form-item -padded">
            <label class="field-label" for="{{ correspondence()->getAttribute($message, 'reportback_id') }}">Reportback ID</label>
            <input class="text-field" type="text" name="{{ correspondence()->getAttribute($message, 'reportback_id') }}" id="{{ correspondence()->getAttribute($message, 'reportback_id') }}" value="{{ correspondence($message, 'reportback_id') }}" />
        </div>

        <div class="form-item -padded">
            <label class="field-label" for="{{ correspondence()->getAttribute($message, 'reportback_item_id') }}">Reportback Item ID</label>
            <input class="text-field" type="text" name="{{ correspondence()->getAttribute($message, 'reportback_item_id') }}" id="{{ correspondence()->getAttribute($message, 'reportback_item_id') }}" value="{{ correspondence($message, 'reportback_item_id') }}" />
        </div>

        <div class="form-item -padded">
            <label class="field-label" for="{{ correspondence()->getAttribute($message, 'signoff') }}">Signoff:</label>
            <textarea class="text-field" name="{{ correspondence()->getAttribute($message, 'signoff') }}" id="{{ correspondence()->getAttribute($message, 'signoff') }}" rows="3">{{ correspondence($message, 'signoff') }}</textarea>
        </div>
    @endif

    <input type="hidden" name="{{ correspondence()->getAttribute($message, 'label') }}" value="{{ correspondence($message, 'label') }}" />
</fieldset>
