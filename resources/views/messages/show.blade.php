@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Competitions',
        'subtitle' => 'Viewing messages in contest ' . $messages[0]->contest_id
    ])


     <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <h2 class="heading -banner">Messages</h2>
                <table class="table">
                    <thead>
                        <tr class="table__header">
                            <th class="table__cell">Label</th>
                            <th class="table__cell">Subject</th>
                            <th class="table__cell">Body</th>
                            <th class="table__cell">Test send</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($messages as $message)
                            <tr class="table__row">
                                <td class="table__cell">{{ $message->label or 'N/A'}}</td>
                                <td class="table__cell">{{ $message->subject or 'N/A'}}</td>
                                <td class="table__cell">{{ str_limit($message->body, 100)}}</td>
                                <td class="table__cell"><a href="{{ route('messages.send', ['message' => $message->id, 'contest_id' => $message->contest_id]) }}" class="button -tertiary ">Send</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@stop
