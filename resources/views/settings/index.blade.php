@extends('layouts.master')

@section('main_content')

    @include('layouts.header',[
        'title' => 'Settings',
        'subtitle' => 'Manage options &amp; customizations'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <ul class="list">
                    <li><a href="{{ url('settings/messages') }}">Messages: Configure defaults</a></li>
                </ul>
            </div>
        </div>
    </div>

@stop
