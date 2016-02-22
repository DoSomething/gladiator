@extends('layouts.master')

@section('main_content')

    <h1>All Competitions</h1>
    @foreach($competitions as $competition)
        <hr>
        <div>
            <h1>Competition ID: {{ $competition->id }}</h1>
            <h3>Campaign ID: {{ $competition->campaign_id }}</h3>
            <h3>Campaign Run ID: {{ $competition->campaign_run_id }}</h3>
            <h3>Start Date: {{ $competition->start_date }}</h3>
            <h3>End Date: {{ $competition->end_date }}</h3>
        </div>
    @endforeach

@stop
