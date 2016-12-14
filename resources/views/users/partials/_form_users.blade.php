@include('layouts.errors')

{{ csrf_field() }}

@if (isset($user->first_name))
    <div class="form-item -padded">
        <label class="field-label">First Name:</label>
        <input type="text" class="text-field" value="{{ $user->first_name }}" disabled />
    </div>
@endif

@if (isset($user->first_name))
    <div class="form-item -padded">
        <label class="field-label">Last Name:</label>
        <input type="text" class="text-field" value="{{ $user->last_name }}" disabled />
    </div>
@endif

@if (isset($user->first_name))
    <div class="form-item -padded">
        <label class="field-label">Email:</label>
        <input type="text" class="text-field" value="{{ $user->email }}" disabled />
    </div>
@endif

<div class="form-item -padded">
    <label class="field-label" for="id">User identification:</label>
    <input type="text" name="id" id="id" class="text-field" placeholder="Email, Mobile Phone Number, Northstar ID or Phoenix ID" value="{{ $user->northstar_id or old('id') }}"/>
</div>

<div class="form-item -padded">
    <label class="field-label" for="term">Select user ID type:</label>
    <div class="select">
        <select name="term" id="term">
            <option value="email" {{! isset($user->northstar_id) ? 'selected' : '' }}>Email</option>
            <option value="mobile">Mobile Phone Number</option>
            <option value="id" {{ isset($user->northstar_id) ? 'selected' : '' }}>Northstar ID</option>
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
