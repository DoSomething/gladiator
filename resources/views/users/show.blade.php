@extends('layouts.master')

@section('main_content')

    @include('layouts.header',[
        'title' => 'Users'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <h1 class="heading">First Last</h1>
                <p><em>Need to grab user first and last name from cache once we cache their Northstar data</em></p>

                <div class="key-value">
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
