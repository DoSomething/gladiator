@include('layouts.errors')

<fieldset>
    <h3 class="heading">{{ $label }} email:</h3>

    <div class="form-item -padded">
        <label class="field-label" for="messages[{{ $type }}][{{ $key }}][subject]">Subject:</label>
        <input class="text-field" type="text" name="messages[{{ $type }}][{{ $key }}][subject]" id="messages[{{ $type }}][{{ $key }}][subject]" value="" />
    </div>

    <div class="form-item -padded">
        <label class="field-label" for="messages[{{ $type }}][{{ $key }}][body]">Body:</label>
        <textarea class="text-field" name="messages[{{ $type }}][{{ $key }}][body]" id="messages[{{ $type }}][{{ $key }}][body]" rows="10"></textarea>
    </div>
</fieldset>
