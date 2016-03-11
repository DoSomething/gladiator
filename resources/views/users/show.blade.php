@extends('layouts.master')

@section('main_content')

    @include('layouts.header',[
        'title' => 'Users'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <h1 class="heading">{{ $user->first_name . ' ' . $user->last_name }}</h1>

                <div class="key-value">
                    <dt>Email:</dt>
                    <dd>{{ $user->email }}</dd>
                    <dt>ID:</dt>
                    <dd>{{ $user->id }}</dd>
                    <dt>Role:</dt>
                    <dd>{{ $user->role or 'member' }}</dd>
                </div>

                <a href="{{ route('users.edit', $user->id) }}" class="button">Edit</a>
            </div>
        </div>
    </div>

@stop
