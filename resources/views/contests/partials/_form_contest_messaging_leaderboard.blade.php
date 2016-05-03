<div class="form-item -padded">
    <label class="field-label" for="{{ correspondence()->getAttribute($message, 'pro_tip') }}">Pro Tip:</label>
    <textarea class="text-field" name="{{ correspondence()->getAttribute($message, 'pro_tip') }}" id="{{ correspondence()->getAttribute($message, 'pro_tip') }}" rows="3">{{ correspondence($message, 'pro_tip') }}</textarea>
</div>

<div class="form-item -padded">
    <label class="field-label" for="{{ correspondence()->getAttribute($message, 'signoff') }}">Signoff:</label>
    <textarea class="text-field" name="{{ correspondence()->getAttribute($message, 'signoff') }}" id="{{ correspondence()->getAttribute($message, 'signoff') }}" rows="3">{{ correspondence($message, 'signoff') }}</textarea>
</div>
