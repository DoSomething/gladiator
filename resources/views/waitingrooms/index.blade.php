@extends('layouts.master')

@section('main_content')

    @include('layouts.header',[
        'title' => 'Waiting Rooms'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr class="table__header">
                          <th class="table__cell">Waiting Room ID</th>
                          <th class="table__cell">Contest ID</th>
                          <th class="table__cell">Signup Start Date</th>
                          <th class="table__cell">Signup End Date</th>
                          <th class="table__cell">Split</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($rooms as $room)
                          <tr class="table__row">
                            <td class="table__cell"><a href="{{ route('waitingrooms.show', $room->id) }}">{{ $room->id }}</a></td>
                            {{-- TODO: Link to contest. --}}
                            <td class="table__cell"><a href="#">{{ $room->contest_id }}</a></td>
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
