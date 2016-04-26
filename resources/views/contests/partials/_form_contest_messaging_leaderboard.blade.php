<div class="form-item -padded">
    <label class="field-label" for="{{ correspondence()->getAttribute($message, 'pro_tip') }}">Pro Tip:</label>
    <textarea class="text-field" name="{{ correspondence()->getAttribute($message, 'pro_tip') }}" id="{{ correspondence()->getAttribute($message, 'pro_tip') }}" rows="3">{{ correspondence($message, 'pro_tip') }}</textarea>
</div>

<div class="form-item -padded">
    <label class="field-label" for="{{ correspondence()->getAttribute($message, 'reportback_id') }}">Featured Reportback ID</label>
    <input class="text-field" type="text" name="{{ correspondence()->getAttribute($message, 'reportback_id') }}" id="{{ correspondence()->getAttribute($message, 'reportback_id') }}" value="{{ correspondence($message, 'reportback_id') }}" />
</div>

<div class="form-item -padded">
    <label class="field-label" for="{{ correspondence()->getAttribute($message, 'reportback_item_id') }}">Featured Reportback Item ID</label>
    <input class="text-field" type="text" name="{{ correspondence()->getAttribute($message, 'reportback_item_id') }}" id="{{ correspondence()->getAttribute($message, 'reportback_item_id') }}" value="{{ correspondence($message, 'reportback_item_id') }}" />
</div>

<div class="form-item -padded">
    <label class="field-label" for="{{ correspondence()->getAttribute($message, 'shoutout') }}">Featured Reportback Shout Out:</label>
    <textarea class="text-field" name="{{ correspondence()->getAttribute($message, 'shoutout') }}" id="{{ correspondence()->getAttribute($message, 'shoutout') }}" rows="3">{{ correspondence($message, 'shoutout') }}</textarea>
</div>

<div class="form-item -padded">
    <label class="field-label" for="{{ correspondence()->getAttribute($message, 'signoff') }}">Signoff:</label>
    <textarea class="text-field" name="{{ correspondence()->getAttribute($message, 'signoff') }}" id="{{ correspondence()->getAttribute($message, 'signoff') }}" rows="3">{{ correspondence($message, 'signoff') }}</textarea>
</div>