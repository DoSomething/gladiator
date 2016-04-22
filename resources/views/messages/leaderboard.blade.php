{!! $content['body'] !!}

<br><br>

@if (count($content['topThree']))
    @include('messages.partials._topthree_table', ['topThree' => $content['topThree']])
@endif

@if (count($content['leaderboard']))
    @include('messages.partials._leaderboard_table', ['leaderboard' => $content['leaderboard']])
@endif

<br><br>

{!! $content['signoff'] !!}
