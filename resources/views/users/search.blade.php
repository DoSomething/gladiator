@extends('layouts.master')

@section('main_content')

    @include('layouts.header',[
        'title' => 'Search Results'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <a class="button" href="{{ route('users.create') }}">Add User</a>
            </div>

            <div class="container__block">
                @include('search.search')
            </div>

            <div class="container__block">
                <p>Your search for &lsquo;{{ $query }}&rsquo; returned <strong>{{ number_format($users->count()) }} results</strong>.</p>
            </div>
        </div>
    </div>

    @if ($users->count())
        @include('users.partials._table_users', ['users' => $users, 'role' => 'Users'])
    @endif

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <p>View the list of all <a href="{{ route('users.contestants') }}">Contestants</a> in Gladiator.</p>
            </div>
        </div>
    </div>

@stop
