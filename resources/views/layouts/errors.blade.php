@if ($errors->count())
    <div class="validation-error fade-in-up">
        <h4>Hmm, there were some issues with that submission:</h4>
        <ul class="list -compacted">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
