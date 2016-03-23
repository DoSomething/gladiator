@extends('layouts.master')

@section('main_content')

    @include('layouts.header',[
        'title' => 'Waiting Room Banana Split'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block -narrow">
                <form method="POST" action="{{ route('split', $room->id) }}">
                    {{ method_field('POST') }}
                    {{ csrf_field() }}

                    <input type="submit" class="button" value="Split" />
                </form>
            </div>

            <div class="container__block">
                <h1>Proposed Competitions</h1>
                <table class="table">
                    <thead>
                        <tr class="table__header">
                            <th class="table__cell">Competition</th>
                            <th class="table__cell">Total Users</th>
                            <th class="table__cell">Set End Date</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($split as $key => $competition)
                            <tr class="table__row">
                                <td class="table__cell">{{ $key + 1 }}</td>
                                <td class="table__cell">{{ $competition->count() }}</td>
                                <td class="table__cell">something</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
