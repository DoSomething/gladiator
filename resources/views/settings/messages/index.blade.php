{{ dd($settings) }}

@extends('layouts.master')

@section('main_content')

    @include('layouts.header',[
        'title' => 'Settings',
        'subtitle' => 'Default Messages Customization'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <ul class="list">
                    <h2 class="heading">Default Messages</h2>

                    @foreach($settings as $label => $setting)
                        {{-- dd($setting) --}}

                        <fieldset>
                            <h3>{{ $label }}</h3>

                            @foreach($setting as $field)
                                @include('settings.partials._form_' . $field['meta_data']->field_type . '_field', ['field' => $field])
                            @endforeach

                        </fieldset>

                        {{-- @include('settings.partials._form_' . $item->value->field_type . '_field', ['item' => (object) ['meta_data' => [ 'field_description' => 'hello', 'field_label' => 'poopie' ], 'value' => 'shit']]) --}}
                    @endforeach

                </ul>
            </div>
        </div>
    </div>

@stop
