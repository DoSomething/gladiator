@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Competitions Messaging',
        'subtitle' => 'Viewing messages in competition ' . $messages[0]->competition_id
    ])

     <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <h2 class="heading -banner">Send Messages</h2>
                <table class="table">
                    <thead>
                        <tr class="table__header">
                            <th class="table__cell">Label</th>
                            <th class="table__cell">Subject</th>
                            <th class="table_cell">Featured Reportback</th>
                            <th class="table_cell">Leaderboard Photos</th>
                            <th class="table__cell">Test Send</th>
                            <th class="table__cell">Live Send</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($messages as $message)
                            <tr class="table__row">
                                <td class="table__cell"> <a href="{{ route('messages.edit', $message->contest_id)}}#{{ $message->type . $message->key }}">{{ $message->label or 'N/A'}}</a></td>
                                <td class="table__cell">{{ $message->subject or 'N/A'}}</td>
                                <td class="table__cell">
                                    @if ($message->type === "leaderboard")
                                        <a href="{{ route('competitions.editFeatureReportback', ['competition' => $competition->id, 'message' => $message->id]) }}" class="button -secondary">{{ isset($featuredReportbacks[$message->id]) ? 'Edit RB' : 'Set RB' }}</a>
                                    @endif

                                </td>
                                <td class="table__cell">
                                    @if ($message->type === "leaderboard")
                                        <a href="{{ route('competitions.editLeaderboardPhotos', ['competition' => $competition->id, 'message' => $message->id]) }}" class="button -secondary">{{ isset($leaderboardPhotos[$message->id]) ? 'Edit Photos' : 'Set Photos' }}</a>
                                    @endif

                                </td>
                                <td class="table__cell"><a href="{{ route('messages.send', ['message' => $message->id, 'contest_id' => $message->contest_id, 'competition_id' => $competition->id, 'test' => true, ]) }}" class="button -tertiary">Test</a></td>
                                <td class="table__cell"><a href="{{ route('messages.send', ['message' => $message->id, 'contest_id' => $message->contest_id, 'competition_id' => $competition->id]) }}" class="button -tertiary">Send</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@stop
