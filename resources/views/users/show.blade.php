@extends('layouts.master')

@section('main_content')

    @include('layouts.header',[
        'title' => 'Users'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <h1 class="heading">{{ $user->first_name }} {{ $user->last_name or '' }}</h1>

                <div class="key-value">
                    <dt>Email:</dt>
                    <dd>{{ $user->email }}</dd>
                    <dt>ID:</dt>
                    <dd>{{ $user->id }}</dd>
                    <dt>Role:</dt>
                    <dd>{{ $user->role or 'member' }}</dd>
                </div>

                <a href="{{ route('users.edit', $user->id) }}" class="button">Edit</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <h2 class="heading -banner">User Activity</h2>
                <table class="table">
                    <thead>
                        <tr class="table__header">
                            <th class="table__cell">Competition</th>
                            <th class="table__cell">Campaign</th>
                            <th class="table__cell">Campaign Run</th>
                            <th class="table__cell">Reportback</th>
                            <th class="table__cell">Quantity</th>
                            <th class="table__cell">Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($competitions as $competition)
                            <tr class="table__row">
                                <td class="table__cell">
                                    <a href="{{ route('competitions.show', $competition->id) }}">
                                        {{ $competition->id }}
                                    </a>
                                </td>
                                <td class="table__cell">{{ $competition->contest->campaign_id}}</td>
                                <td class="table__cell">{{ $competition->contest->campaign_run_id }}</td>
                                <td class="table__cell">
                                    {{-- @TODO need better way of doing this linking --}}
                                    <a href="{{ env('PHOENIX_PROD') . '/admin/reportback/' . $competition->user_signup->reportback->id }}">
                                        {{ $competition->user_signup->reportback->id }}</td>
                                    </a>
                                <td class="table__cell">{{ $competition->user_signup->reportback->quantity }}</td>
                                <td class="table__cell">{{ $competition->user_signup->reportback->updated_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
