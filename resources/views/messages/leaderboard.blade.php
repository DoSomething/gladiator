{!! $content['body'] !!}
<br><br>
@if (count($content['leaderboard']))
    @include('messages.partials._leaderboard_table', ['leaderboard' => $content['leaderboard']])
@endif
<br><br>
{!! $content['signoff'] !!}
