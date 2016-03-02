@extends('layouts.master')

@section('main_content')

    @include('layouts.header',[
        'title' => 'Waiting Rooms'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <a class="button" href="{{ route('waitingrooms.create') }}">Add Waiting Room</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr class="table__header">
                          <th class="table__cell">ID</th>
                          <th class="table__cell">Campaign</th>
                          <th class="table__cell">Campaign Run</th>
                          <th class="table__cell">Start Date</th>
                          <th class="table__cell">End Date</th>
                          <th class="table__cell">Split</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($rooms as $room)
                          <tr class="table__row">
                            <td class="table__cell"><a href="{{ route('waitingrooms.show', $room->id) }}">{{ $room->id }}</a></td>
                            <td class="table__cell">{{ $room->campaign_id }}</td>
                            <td class="table__cell">{{ $room->campaign_run_id }}</td>
                            <td class="table__cell">{{ date('F d, Y', strtotime($room->signup_start_date)) }}</td>
                            <td class="table__cell">{{ date('F d, Y', strtotime($room->signup_end_date)) }}</td>
                            <td class="table__cell">
                                @if (hasSignupPeriodEnded($room->signup_end_date))
                                    <a href="{{ route('split', $room->id) }}" class="button -secondary">Split room</a>
                                @else
                                    <p>N/A</p>
                                @endif
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop
