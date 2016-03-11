@extends('layouts.master')

@section('main_content')

    @include('layouts.header',[
        'title' => 'Users'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <a class="button" href="{{ route('users.create') }}">Add User</a>
            </div>
        </div>
    </div>

    @if (count($users['admins']) > 0)
        @include('users.partials._table_users', ['users' => $users['admins'], 'role' => 'Admins'])
    @endif

    @if (count($users['staff']) > 0)
        @include('users.partials._table_users', ['users' => $users['staff'], 'role' => 'Staff'])
    @endif

    @if (count($users['contestants']) > 0)
        @include('users.partials._table_users', ['users' => $users['contestants'], 'role' => 'Contestants'])
    @endif

@stop
