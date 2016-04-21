@extends('layouts.master')

@section('main_content')

    @include('layouts.header',[
        'title' => 'Users'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <a class="button" href="{{ route('users.create') }}">Add User</a>
                <a class="button" href="{{ route('users.contestants') }}">Contestants</a>
            </div>
        </div>
    </div>

    @if ($admins->count())
        @include('users.partials._table_users', ['users' => $admins, 'role' => 'Admins'])
    @endif

    @if ($staff->count())
        @include('users.partials._table_users', ['users' => $staff, 'role' => 'Staff'])
    @endif

@stop
