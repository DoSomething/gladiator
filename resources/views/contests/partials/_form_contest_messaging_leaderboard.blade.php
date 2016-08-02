<div class="form-item -padded">
    <label class="field-label" for="{{ correspondence()->getAttribute($message, 'pro_tip') }}">Pro Tip:</label>
    <textarea class="text-field" name="{{ correspondence()->getAttribute($message, 'pro_tip') }}" id="{{ correspondence()->getAttribute($message, 'pro_tip') }}" rows="3">{{ correspondence($message, 'pro_tip') }}</textarea>
</div>

<div class="form-item -padded">
    <label class="field-label" for="{{ correspondence()->getAttribute($message, 'signoff') }}">Signoff:</label>
    <textarea class="text-field" name="{{ correspondence()->getAttribute($message, 'signoff') }}" id="{{ correspondence()->getAttribute($message, 'signoff') }}" rows="3">{{ correspondence($message, 'signoff') }}</textarea>
</div>

<div class="form-item -padded">
    <label class="option -checkbox">
        <input @if (correspondence()->get($message, 'show_images')) checked @endif type="checkbox" value="1" name="{{ correspondence()->getAttribute($message, 'show_images') }}" id="{{ correspondence()->getAttribute($message, 'show_images') }}">
        <span class="option__indicator"></span>
        <span>Show images</span>
    </label>
</div>
