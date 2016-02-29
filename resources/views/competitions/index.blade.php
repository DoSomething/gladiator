@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Competitions'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block -narrow">
                <a class="button" href="{{ route('competitions.create') }}">Add Competition</a>
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
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($competitions as $competition)
                          <tr class="table__row">
                            <td class="table__cell"><a href="{{ route('competitions.show', $competition->id) }}">{{ $competition->id }}</a></td>
                            <td class="table__cell">{{ $competition->campaign_id }}</td>
                            <td class="table__cell">{{ $competition->campaign_run_id }}</td>
                            <td class="table__cell">{{ date('F d, Y', strtotime($competition->start_date)) }}</td>
                            <td class="table__cell">{{ date('F d, Y', strtotime($competition->end_date)) }}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
