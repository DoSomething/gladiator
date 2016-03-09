@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Contests',
        'subtitle' => 'Add a new contest'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block -narrow">
                {!! Form::open(['route' => 'contest.store']) !!}

                    @include('contest.partials._form_contest')

                {!! Form::close() !!}
            </div>
        </div>
    </div>

@stop
