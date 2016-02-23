@extends('layouts.master')

@section('main_content')

    <div>
        <h1>Competition ID: {{ $competition->id }}</h1>
        <h3>Campaign ID: {{ $competition->campaign_id }}</h3>
        <h3>Campaign Run ID: {{ $competition->campaign_run_id }}</h3>
        <h3>Start Date: {{ $competition->start_date }}</h3>
        <h3>End Date: {{ $competition->end_date }}</h3>
    </div>
    <div>
        <li>
            {!! Form::open(['method' => 'DELETE','route' => ['competitions.destroy', $competition->id]]) !!}
            {!! Form::submit('Delete', array('class' => 'button delete')) !!}
            {!! Form::close() !!}
        </li>
        <li>
            <a href="{{ route('competitions.edit', $competition->id) }}" class="button">Edit Competition</a>
        </li>
    </div>

@stop
