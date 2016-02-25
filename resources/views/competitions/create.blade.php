@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Competitions',
        'subtitle' => 'Add a new competition'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block -narrow">
                {!! Form::open(['route' => 'competitions.store']) !!}

                    @include('competitions.partials._form_competitions')

                {!! Form::close() !!}
            </div>
        </div>
    </div>

@stop
