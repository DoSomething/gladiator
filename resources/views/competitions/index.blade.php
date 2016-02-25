@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Competitions'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block -narrow">
                <a class="button" href="{{ route('competitions.create') }}">Add Competition</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                @foreach($competitions as $competition)
                    <hr>
                    <div>
                        <h3><a href="{{ route('competitions.show', $competition->id) }}">Competition ID: {{ $competition->id }}</a></h3>
                        <p>Campaign ID: {{ $competition->campaign_id }}</p>
                        <p>Campaign Run ID: {{ $competition->campaign_run_id }}</p>
                        <p>Start Date: {{ $competition->start_date }}</p>
                        <p>End Date: {{ $competition->end_date }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@stop
