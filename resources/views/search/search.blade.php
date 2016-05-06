<div class="form-actions -inline">
    <form method="GET" action="{{ route('users.search')}}">
        {{ csrf_field() }}

        <li>
            <input class="text-field -search" type="text" name="search" placeholder="Search"  />
        </li>

        <li>
            <input type="submit" class="button" value="Submit" />
        </li>
    </form>
</div>


{{-- {{ route('contests.update', $contest->id) }} --}}