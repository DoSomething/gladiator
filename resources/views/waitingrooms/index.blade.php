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

                <table id="user-table" class="table">
                  <thead>
                    <tr class="row table-header">
                      <th class="table-cell">ID</th>
                      <th class="table-cell">Campaign</th>
                      <th class="table-cell">Campaign Run</th>
                      <th class="table-cell">Start Date</th>
                      <th class="table-cell">End Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($rooms as $room)
                      <tr class="table-row">
                        <td class="table-cell"><a href="{{ route('waitingrooms.show', $room->id) }}">{{ $room->id }}</a></td>
                        <td class="table-cell">{{ $room->campaign_id }}</td>
                        <td class="table-cell">{{ $room->campaign_run_id }}</td>
                        <td class="table-cell">{{ date('F d, Y', strtotime($room->signup_start_date)) }}</td>
                        <td class="table-cell">{{ date('F d, Y', strtotime($room->signup_end_date)) }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
        </div>
    </div>

@stop
