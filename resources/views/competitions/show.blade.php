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
                <h3>Users in this competition ({{ count($bracket) }}):</h3>
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
                        @foreach($bracket as $user)
                            @if ($user)
                                <tr class="table__row">
                                    <td class="table__cell"><a href="{{ route('users.show', $user['id'])}}">{{ $user['name'] }}</a></td>
                                    <td class="table__cell">{{ $user['email'] or '' }}</td>
                                    <td class="table__cell">{{ $user['phone'] or ''}}</td>
                                    <!-- TODO: Link to the users signup data for this competition -->
                                    <td class="table__cell">
                                        <a href="#">View Activity</a>
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
