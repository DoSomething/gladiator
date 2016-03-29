@include('layouts.errors')

<fieldset>
    <h3 class="heading">{{ $default['label'] }} email:</h3>

    <div class="form-item -padded">
        <label class="field-label" for="messages[{{ $type }}][{{ $key }}][subject]">Subject:</label>
        <input class="text-field" type="text" name="messages[{{ $type }}][{{ $key }}][subject]" id="messages[{{ $type }}][{{ $key }}][subject]" value="{{ $default['subject'] }}" />
    </div>

    <div class="form-item -padded">
        <label class="field-label" for="messages[{{ $type }}][{{ $key }}][body]">Body:</label>
        <textarea class="text-field" name="messages[{{ $type }}][{{ $key }}][body]" id="messages[{{ $type }}][{{ $key }}][body]" rows="10">{{ $default['body'] }}</textarea>
    </div>

    <input type="hidden" name="messages[{{ $type }}][{{ $key }}][label]" value="{{ $default['label'] }}" />
</fieldset>
