@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Competitions',
        'subtitle' => 'Edit competition ' . $competition->id
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                {!! Form::model($competition, ['method' => 'PATCH', 'route' => ['competitions.update', $competition->id]]) !!}

                    @include('competitions.partials._form_competitions')

                {!! Form::close() !!}
            </div>
        </div>
    </div>

@stop
