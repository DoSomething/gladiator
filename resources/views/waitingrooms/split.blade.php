@extends('layouts.master')

@section('main_content')

    @include('layouts.header',[
        'title' => 'Waiting Room Banana Split'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <h1>{{ count($split) . ' Proposed ' . ((count($split) === 1) ? 'Competition' : 'Competitions') }}</h1>
            </div>
            @if (count($split))
                <form method="POST" action="{{ route('split', $room->id) }}">
                    {{ method_field('POST') }}
                    {{ csrf_field() }}

                    <div class="container__block">
                        <div class="form-item -padded">
                            <label class="field-label" for="competition_end_date">End date for these competitions:</label>
                            <input type="date" name="competition_end_date" id="competition_end_date" value='MM/DD/YYYY' class="text-field"></input>
                        </div>

                        <input type="submit" class="button" value="Split" />
                    </div>

                    <div class="container__block">
                        <table class="table">
                            <thead>
                                <tr class="table__header">
                                    <th class="table__cell">Competition</th>
                                    <th class="table__cell"># of Contestants</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($split as $key => $competition)
                                    <tr class="table__row">
                                        <td class="table__cell">{{ $key }}</td>
                                        <td class="table__cell">{{ count($competition) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            @endif
        </div>
    </div>
@stop
