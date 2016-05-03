{{-- Setting Text Field --}}
<div class="form-item -padded">
    hello
</div>


{{-- Example from Longshot
<div class="form-group">
  {!! Form::label($setting->key, snakeCaseToTitleCase($setting->key) . ': ') !!}
  @if ($setting->description)
    <p><em class="text-muted">{{ $setting->description }}</em></p>
  @endif
  {!! Form::text($setting->key, $setting->value, ['class' => 'form-control', 'placeholder' => 'enter value']) !!}
  {!! errorsFor($setting->key, $errors); !!}
</div>
--}}
