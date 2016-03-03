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

    @if (count($admins) > 0)
        @include('users.partials._table_users', ['users' => $admins, 'role' => 'Admins'])
    @endif

    @if (count($staff) > 0)
        @include('users.partials._table_users', ['users' => $staff, 'role' => 'Staff'])
    @endif

    @if (count($contestants) > 0)
        @include('users.partials._table_users', ['users' => $contestants, 'role' => 'Contestants'])
    @endif

@stop
