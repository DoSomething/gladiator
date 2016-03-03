@extends('layouts.master')

@section('main_content')

    @include('layouts.header',[
        'title' => 'Users',
        'subtitle' => 'Add a new user'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <form method="POST" action="{{ route('users.create') }}">
                    @include('users.partials._form_users')
                </form>
            </div>
        </div>
    </div>

@stop
