{!! $content['body'] !!}

<br><br>

@if (isset($content['featuredReportback']))
    @include('messages.partials._featured_reportback', ['featuredReportback' => $content['featuredReportback']])
@endif

@if (isset($content['topThree']))
    @include('messages.partials._topthree_table', ['topThree' => $content['topThree'], 'reportbackInfo' => $content['reportbackInfo']])
@endif

@if (isset($content['leaderboard']))
    @include('messages.partials._leaderboard_table', ['leaderboard' => $content['leaderboard']])
@endif

{!! $content['signoff'] !!}
