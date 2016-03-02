@if (Session::has('status'))
    <div class="messages">{{ Session::get('status') }}</div>
@endif
