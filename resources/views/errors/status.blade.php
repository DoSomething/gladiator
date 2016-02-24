@if (Session::has('status'))
    <div>{{ Session::get('status') }}</div>
@endif

@if(isset($errors) && $errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
