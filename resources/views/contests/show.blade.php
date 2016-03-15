@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Contests',
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
                <ul class="form-actions -inline">
                    <li>
                        <a href="{{ route('contests.edit', $contest->id) }}" class="button">Edit</a>
                    </li>
                    <li>
                        <a href="{{ route('contests.export', $contest->id) }}" class="button">Export</a>
                    </li>
                    <li>
                        <a href="{{ route('split', $contest->waitingRoom->id) }}" class="button">Split</a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('contests.destroy', $contest->id) }}">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}

                            <input type="submit" class="button" value="Delete" />
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

@stop
