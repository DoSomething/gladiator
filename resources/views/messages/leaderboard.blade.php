{!! $content['body'] !!}

<br><br>

@if (isset($content['topThree']))
    @include('messages.partials._topthree_table', ['topThree' => $content['topThree'], 'reportbackInfo' => $content['reportbackInfo']])
@endif

@if (isset($content['leaderboard']))
    @include('messages.partials._leaderboard_table', ['leaderboard' => $content['leaderboard']])
@endif

<h2>Testing featured reportback</h2>
{{ $content['featuredReportback']['caption']}}
<br><br>

{!! $content['signoff'] !!}
