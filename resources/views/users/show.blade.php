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
                            <th class="table__cell">Contest</th>
                            <th class="table__cell">Competition</th>
                            <th class="table__cell">Reportback</th>
                            <th class="table__cell">Items</th>
                            <th class="table__cell">Quantity</th>
                            <th class="table__cell">Updated At</th>
                            <th class="table__cell">Flagged</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($competitions as $competition)
                            <tr class="table__row">
                                <td class="table__cell">
                                    <a href="{{ route('contests.show', $competition->contest->id) }}">
                                        {{ $competition->contest->id }}
                                    </a>
                                </td>
                                <td class="table__cell">
                                    <a href="{{ route('competitions.show', $competition->id) }}">
                                        {{ $competition->id }}
                                    </a>
                                </td>
                                <td class="table__cell">
                                    <a href="{{ env('PHOENIX_URL') . '/admin/reportback/' . $competition->user_signup->reportback->id }}">
                                        {{ $competition->user_signup->reportback->id or 'N/A' }}</td>
                                    </a>
                                <td class="table__cell">{{ $competition->user_signup->reportback->reportback_items->total or 'N/A' }}</td>
                                <td class="table__cell">{{ $competition->user_signup->reportback->quantity or 'N/A' }}</td>
                                <td class="table__cell">{{ $competition->user_signup->reportback->updated_at or 'N/A' }}</td>
                                <td class="table__cell">{{ ($competition->user_signup->reportback->flagged) ? 'Yes' : 'No' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
