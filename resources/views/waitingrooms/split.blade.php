@extends('layouts.master')

@section('main_content')

    @include('layouts.header',[
        'title' => 'Waiting Room Banana Split'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block container__competitions">
                <h1>Competitions</h1>
                @foreach($split as $competition)
                    <div class="container__split">
                        <h1>{{ count($competition) }} Users</h1>
                        <ul>
                            @foreach($competition as $user)
                                <li>{{ $user }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
            <div class="container__block -narrow">
                <h1>Competition details</h1>
                {!! Form::open(['method' => 'POST','route' => ['split', $room->id]]) !!}

                    @include('competitions.partials._form_competitions')

                {!! Form::close() !!}
            </div>
        </div>
    </div>

@stop
