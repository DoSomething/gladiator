@extends('layouts.master')

@section('main_content')

    @include('layouts.header',[
        'title' => 'Users',
        'subtitle' => 'Edit user ' . $user->id
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <form method="POST" action="/users">
                    @include('users.partials._form_users')
                </form>
            </div>
        </div>
    </div>

@stop
