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
                        @include('settings.partials._form_' . $item->field_type . '_field', ['item' => $item])
                    @endforeach

                </ul>
            </div>
        </div>
    </div>

@stop
