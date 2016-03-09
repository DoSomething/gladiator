@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Contest',
        'subtitle' => 'Viewing contest ' . $contest->id
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block -half">
                <ul>
                    <li><strong>Contest ID:</strong> {{ $contest->campaign_id }}</li>
                    <li><strong>Contest Run ID:</strong> {{ $contest->campaign_run_id }}</li>
                    <li><strong>Duration:</strong> {{ $contest->duration }}</li>
                </ul>
            </div>
            <div class="container__block -half">
                {{-- <ul class="form-actions -inline">
                    <li>
                        <a href="{{ route('contest.edit', $contest->id) }}" class="button">Edit</a>
                    </li>
                    <li>
                        {!! Form::open(['method' => 'DELETE','route' => ['contest.destroy', $contest->id]]) !!}

                            {!! Form::submit('Delete', array('class' => 'button delete')) !!}

                        {!! Form::close() !!}
                    </li>
                </ul> --}}
            </div>
        </div>
    </div>

@stop
