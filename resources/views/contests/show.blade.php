@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Contests',
        'subtitle' => 'Viewing contest ID: ' . $contest->id
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block -half">
                <ul>
                    <li><strong>Campaign ID:</strong> {{ $contest->campaign_id }}</li>
                    <li><strong>Campaign Run ID:</strong> {{ $contest->campaign_run_id }}</li>
                    <li><strong>Duration:</strong> {{ $contest->duration }}</li>
                </ul>
            </div>

            <div class="container__block -half">
                <ul class="form-actions -inline">
                    <li>
                        <a href="{{ route('contests.edit', $contest->id) }}" class="button -secondary">Edit</a>
                    </li>
                    <li>
                        <a href="{{ route('contests.export', $contest->id) }}" class="button -secondary">Export</a>
                    </li>
                    <li>
                        <a href="{{ route('split', $contest->waitingRoom->id) }}" class="button -secondary">Split</a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('contests.destroy', $contest->id) }}">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}

                            <input type="submit" class="button -danger" value="Delete" />
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <h2 class="heading -alpha">Waiting Room</h2>
                <p>The waiting room currently contains {{ '#' }} contestants.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <h2 class="heading -alpha">Competitions</h2>

                <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr class="table__header">
                          <th class="table__cell">ID</th>
                          <th class="table__cell">Contest ID</th>
                          <th class="table__cell">Start Date</th>
                          <th class="table__cell">End Date</th>
                          <th class="table__cell"># of Contestants</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="table__row">
                            <td class="table__cell"></td>
                            <td class="table__cell"></td>
                            <td class="table__cell"></td>
                            <td class="table__cell"></td>
                            <td class="table__cell"></td>
                        </tr>
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop
