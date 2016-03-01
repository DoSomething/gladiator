@include('layouts.errors')

<div class="form-item -padded">
    <label class="field-label" for="key">User identification key:</label>
    <input type="text" name="key" id="key" class="text-field" placeholder="Email, Mobile Phone Number, Northstar ID or Phoenix ID"/>
</div>

<div class="form-item -padded">
    <label class="field-label" for="type">Select user key type:</label>
    <div class="select">
        <select name="type">
            <option value="email" selected>Email</option>
            <option value="mobile">Mobile Phone Number</option>
            <option value="id">Northstar ID</option>
            <option value="drupal_id">Phoenix ID</option>
        </select>
    </div>
</div>

<input type="submit" class="button" value="Submit" />
