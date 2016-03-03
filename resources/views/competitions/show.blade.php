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
                    <li><strong>Campaign ID:</strong> {{ $competition->campaign_id }}</li>
                    <li><strong>Campaign Run ID:</strong> {{ $competition->campaign_run_id }}</li>
                    <li><strong>Start Date:</strong> {{ date('F d, Y', strtotime($competition->start_date)) }}</li>
                    <li><strong>End Date:</strong> {{ date('F d, Y', strtotime($competition->end_date)) }}</li>
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
                <h3>Users in this competition ({{ count($competitionUsers) }}):</h3>
                <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr class="table__header">
                          <th class="table__cell">Name</th>
                          <th class="table__cell">Email</th>
                          <th class="table__cell">Phone</th>
                          <th class="table__cell">Signup</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($competitionUsers as $user)
                            @if ($user)
                                <tr class="table__row">
                                    <td class="table__cell"><a href="{{ route('users.show', $user['user']->id)}}">{{ $user['user']->first_name }}</a></td>
                                    <td class="table__cell">{{ $user['user']->email }}</td>
                                    <td class="table__cell">{{ $user['user']->mobile }}</td>
                                    <td class="table__cell">
                                        @if ($user['signup'])
                                            <a href="{{ route('users.signup', ['id' => $user['user']->id, 'signup_id' => $user['signup'][0]->id])}}">View Signup</a>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                      </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@stop
