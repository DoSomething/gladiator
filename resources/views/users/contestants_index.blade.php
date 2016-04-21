@extends('layouts.master')

@section('main_content')

    @include('layouts.header',[
        'title' => 'Contestants'
    ])

    @if ($contestants->count())
        @include('users.partials._table_users', ['users' => $contestants, 'role' => 'Contestants'])
    @endif

@stop
