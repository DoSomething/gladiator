@extends('layouts.master')

@section('main_content')

    @include('layouts.header',[
        'title' => 'Waiting Room Banana Split'
    ])

    <form method="POST" action="{{ route('split', $room->id) }}">
        {{ method_field('POST') }}
        {{ csrf_field() }}
        <div class="container">
            <div class="wrapper">
                <div class="container__block -narrow">
                    <div class="form-item -padded">
                        <label class="field-label" for="competition_end_date">End date for these competitions:</label>
                        <input type="date" name="competition_end_date" id="competition_end_date" value='MM/DD/YYYY' class="text-field"></input>
                    </div>

                    <input type="submit" class="button" value="Split" />
                </div>

                <div class="container__block">
                    <h1>{{ count($split) . ' Proposed Competition(s)' }}</h1>
                    <table class="table">
                        <thead>
                            <tr class="table__header">
                                <th class="table__cell">Competition</th>
                                <th class="table__cell">Total Users</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach($split as $key => $competition)
                                <tr class="table__row">
                                    <td class="table__cell">{{ $key + 1 }}</td>
                                    <td class="table__cell">{{ count($competition) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
@stop
