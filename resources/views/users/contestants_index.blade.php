@extends('layouts.master')

@section('main_content')

    @include('layouts.header',[
        'title' => 'Contestants'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                @include('search.search')
            </div>
        </div>
    </div>

    @if ($contestants->count())
        @include('users.partials._table_users', ['users' => $contestants, 'role' => ''])
    @endif

@stop
