@if (Session::has('status'))
    <div>{{ Session::get('status') }}</div>
@endif
