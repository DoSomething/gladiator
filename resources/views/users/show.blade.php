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
                    <dd>{{ $user->northstar_id }}</dd>
                    <dt>Role:</dt>
                    <dd>{{ $user->role or 'member' }}</dd>
                </div>

                <a href="{{ route('users.edit', $user->northstar_id) }}" class="button">Edit</a>
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
                            <th class="table__cell">Remove from Competition</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activities as $competition)
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

                                @if ($competition->reportback)
                                    <td class="table__cell"><a href="{{ reportback_admin_url($competition->reportback->id) }}">{{ $competition->reportback->id }}</a></td>
                                    <td class="table__cell">{{ $competition->reportback->reportback_items->total }}</td>
                                    <td class="table__cell">{{ $competition->reportback->quantity }}</td>
                                    <td class="table__cell">{{ format_timestamp_for_display($competition->reportback->updated_at) }}</td>
                                @else
                                    <td class="table__cell">N/A</td>
                                    <td class="table__cell">N/A</td>
                                    <td class="table__cell">N/A</td>
                                    <td class="table__cell">N/A</td>
                                @endif

                                <td class="table__cell"><a href="{{ route('competitions.users.destroy', ['user' => $user->northstar_id, 'competition' =>$competition->id]) }}" class="button -secondary -danger">Remove</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
