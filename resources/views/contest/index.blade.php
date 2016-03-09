@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Contests'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block -narrow">
                <a class="button" href="{{ route('contest.create') }}">Add Contest</a>
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
                          <th class="table__cell">Duration</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($contests as $contest)
                          <tr class="table__row">
                            {{-- <td class="table__cell"><a href="{{ route('competitions.show', $competition->id) }}">{{ $competition->id }}</a></td> --}}
                            <td class="table__cell">{{ $contest->id }}</td>
                            <td class="table__cell">{{ $contest->campaign_id }}</td>
                            <td class="table__cell">{{ $contest->campaign_run_id }}</td>
                            <td class="table__cell">{{ $contest->duration }}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop
