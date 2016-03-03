@include('layouts.errors')

{{ csrf_field() }}

<div class="form-item -padded">
    <label class="field-label" for="key">User identification key:</label>
    <input type="text" name="key" id="key" class="text-field" placeholder="Email, Mobile Phone Number, Northstar ID or Phoenix ID" value="{{ $user->id or old('key') }}"/>
</div>

<div class="form-item -padded">
    <label class="field-label" for="type">Select user key type:</label>
    <div class="select">
        <select name="type">
            <option value="email" {{! isset($user->id) ? 'selected' : '' }}>Email</option>
            <option value="mobile">Mobile Phone Number</option>
            <option value="id" {{ isset($user->id) ? 'selected' : '' }}>Northstar ID</option>
            <option value="drupal_id">Phoenix ID</option>
        </select>
    </div>
</div>

<div class="form-item -padded">
    <p class="field-label">Specify a role for this user:</p>
    <label class="option -radio">
        <input type="radio" name="role" id="member" value="member" {{ isset($user->role) && $user->role === 'member' ? 'checked' : '' }}>
        <span class="option__indicator"></span>
        <span>Member</span>
    </label>
    <label class="option -radio">
        <input type="radio" name="role" id="staff" value="staff" {{ isset($user->role) && $user->role === 'staff' ? 'checked' : '' }}>
        <span class="option__indicator"></span>
        <span>Staff</span>
    </label>
    <label class="option -radio">
        <input type="radio" name="role" id="admin" value="admin" {{ isset($user->role) && $user->role === 'admin' ? 'checked' : '' }}>
        <span class="option__indicator"></span>
        <span>Admin</span>
    </label>
</div>

<input type="submit" class="button" value="Submit" />