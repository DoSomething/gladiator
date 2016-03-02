@include('layouts.errors')

{{ csrf_field() }}

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

<div class="form-item -padded">
    <p class="field-label">Specify a role for this user:</p>
    <label class="option -radio">
      <input checked type="radio" name="role" id="member" value="member">
      <span class="option__indicator"></span>
      <span>Member</span>
    </label>
    <label class="option -radio">
      <input type="radio" name="role" id="staff" value="staff">
      <span class="option__indicator"></span>
      <span>Staff</span>
    </label>
    <label class="option -radio">
      <input type="radio" name="role" id="admin" value="admin">
      <span class="option__indicator"></span>
      <span>Admin</span>
    </label>
</div>

<input type="submit" class="button" value="Submit" />
