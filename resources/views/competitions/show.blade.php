@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Competitions',
        'subtitle' => 'Viewing competition ' . $competition->id
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <p>Competition ID: {{ $competition->id }}</p>
                <p>Campaign ID: {{ $competition->campaign_id }}</p>
                <p>Campaign Run ID: {{ $competition->campaign_run_id }}</p>
                <p>Start Date: {{ $competition->start_date }}</p>
                <p>End Date: {{ $competition->end_date }}</p>

                <ul class="form-actions -inline">
                    <li>
                        {!! Form::open(['method' => 'DELETE','route' => ['competitions.destroy', $competition->id]]) !!}

                            {!! Form::submit('Delete', array('class' => 'button delete')) !!}

                        {!! Form::close() !!}
                    </li>
                    <li>
                        <a href="{{ route('competitions.edit', $competition->id) }}" class="button">Edit</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

@stop
