@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Contests',
        'subtitle' => 'Edit contest ' . $contest->id
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                {!! Form::model($contest, ['method' => 'PATCH', 'route' => ['contests.update', $contest->id]]) !!}

                    @include('contests.partials._form_contest')

                {!! Form::close() !!}
            </div>
        </div>
    </div>

@stop
