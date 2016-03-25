@include('layouts.errors')

<fieldset>
    <h3 class="heading">{{ ucfirst($type) }} Email</h3>

    <div class="form-item -padded">
        <label class="field-label" for="messages[{{ $type }}][{{ $name }}][subject]">Subject:</label>
        <input class="text-field" type="text" name="messages[{{ $type }}][{{ $name }}][subject]" id="messages[{{ $type }}][{{ $name }}][subject]" value="" />
    </div>

    <div class="form-item -padded">
        <label class="field-label" for="messages[{{ $type }}][{{ $name }}][body]">Body:</label>
        <textarea class="text-field" name="messages[{{ $type }}][{{ $name }}][body]" id="messages[{{ $type }}][{{ $name }}][body]" rows="10"></textarea>
    </div>
</fieldset>
