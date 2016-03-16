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
                    <li><strong>Campaign ID:</strong> {{ $contest->campaign_id }}</li>
                    <li><strong>Campaign Run ID:</strong> {{ $contest->campaign_run_id }}</li>
                    <li><strong>Contest ID:</strong> {{ $competition->contest_id }}</li>
                    <li><strong>Start Date:</strong> {{ $competition->competition_start_date->format('F d, Y') }}</li>
                    <li><strong>End Date:</strong> {{ $competition->competition_end_date->format('F d, Y') }}</li>
                </ul>
            </div>
            <div class="container__block -half">
                <ul class="form-actions -inline">
                    <li>
                        <a href="{{ route('competitions.edit', $competition->id) }}" class="button">Edit</a>
                    </li>
                    <li>
                        <a href="{{ route('competitions.export', $competition->id) }}" class="button">Export</a>
                    </li>
                    <li>
                        {!! Form::open(['method' => 'DELETE','route' => ['competitions.destroy', $competition->id]]) !!}

                            {!! Form::submit('Delete', array('class' => 'button delete')) !!}

                        {!! Form::close() !!}
                    </li>
                </ul>
            </div>
            <div class="container__block">
                <h3>Total Contestants: {{ $competition->users->count() }}</h3>
                <table class="table">
                    <thead>
                        <tr class="table__header">
                            <th class="table__cell">First Name</th>
                            <th class="table__cell">Email</th>
                            <th class="table__cell">Phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $key => $user)
                            @if ($user)
                                <tr class="table__row">
                                    <td class="table__cell"><a href="{{ route('users.show', $user->id) }}">{{ $user->first_name or $user->id }}</td>
                                    <td class="table__cell">{{ $user->email or NULL }}</td>
                                    <td class="table__cell">{{ $user->mobile or NULL }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
