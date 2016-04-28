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
                @include('waitingrooms.partials._form_split')

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
                                    <td class="table__cell">{{ $key + 1 }}</td>
                                    <td class="table__cell">{{ count($competition) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@stop
