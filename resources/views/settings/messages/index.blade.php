{{-- dd($items) --}}

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

                    @foreach($items as $item)
                        {{ dd($item->value) }}

                        <fieldset>
                            <h3>{{ $item->value['label'] }}</h3>

                            @include('settings.partials._form_text_field')
                            {{--
                            @foreach($item->value as $key => $value)
                                {{ dd($data) }}
                            @endforeach
                            --}}
                        </fieldset>

                        {{-- @include('settings.partials._form_' . $item->value->field_type . '_field', ['item' => (object) ['meta_data' => [ 'field_description' => 'hello', 'field_label' => 'poopie' ], 'value' => 'shit']]) --}}
                    @endforeach

                </ul>
            </div>
        </div>
    </div>

@stop
