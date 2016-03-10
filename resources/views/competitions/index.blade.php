@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Competitions'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr class="table__header">
                          <th class="table__cell">ID</th>
                          <th class="table__cell">Contest ID</th>
                          <th class="table__cell">Start Date</th>
                          <th class="table__cell">End Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($competitions as $competition)
                          <tr class="table__row">
                            <td class="table__cell"><a href="{{ route('competitions.show', $competition->id) }}">{{ $competition->id }}</a></td>
                            {{-- TODO: Link to contest--}}
                            <td class="table__cell"><a href="#">{{ $competition->contest_id }}</a></td>
                            <td class="table__cell">{{ $competition->competition_start_date->format('F d, Y') }}</td>
                            <td class="table__cell">{{ $competition->competition_end_date->format('F d, Y') }}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
