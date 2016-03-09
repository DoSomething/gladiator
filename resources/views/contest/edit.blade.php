@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Contest',
        'subtitle' => 'Edit contest ' . $contest->id
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                {!! Form::model($contest, ['method' => 'PATCH', 'route' => ['contest.update', $contest->id]]) !!}

                    @include('contest.partials._form_contest')

                {!! Form::close() !!}
            </div>
        </div>
    </div>

@stop
