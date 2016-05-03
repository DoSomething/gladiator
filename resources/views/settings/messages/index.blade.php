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
                    <h2 class="heading">All Messages</h2>

                </ul>
            </div>
        </div>
    </div>

@stop
