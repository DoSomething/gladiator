@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Competitions',
        'subtitle' => 'Viewing competition ' . $competition->id
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block -half">
                <ul>
                    <li>Campaign ID: {{ $competition->campaign_id }}</li>
                    <li>Campaign Run ID: {{ $competition->campaign_run_id }}</li>
                    <li>Start Date: {{ date('F d, Y', strtotime($competition->start_date)) }}</li>
                    <li>End Date: {{ date('F d, Y', strtotime($competition->end_date)) }}</li>
                </ul>
            </div>
            <div class="container__block -half">
                <ul class="form-actions -inline">
                    <li>
                        <a href="{{ route('competitions.edit', $competition->id) }}" class="button">Edit</a>
                    </li>
                    <li>
                        {!! Form::open(['method' => 'DELETE','route' => ['competitions.destroy', $competition->id]]) !!}

                            {!! Form::submit('Delete', array('class' => 'button delete')) !!}

                        {!! Form::close() !!}
                    </li>
                </ul>
            </div>
            <div class="container__block">
                <h3>Users in this competition:</h3>
                <ul>
                    @foreach($competitionUsers as $user)
                        <li>
                            <a href="#">{{ $user->user_id }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

@stop
