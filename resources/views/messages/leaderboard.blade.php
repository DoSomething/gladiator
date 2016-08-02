{!! $content['body'] !!}

@if (isset($content['featuredReportback']))
    @include('messages.partials._featured_reportback', [
        'messageKey' => $content['key'],
        'featuredReportback' => $content['featuredReportback'],
        'reportbackInfo' => $content['reportbackInfo'],
        'showImages' => $content['show_images'],
    ])
@endif

@if (isset($content['topThree']))
    @include('messages.partials._topthree_table', [
        'messageKey' => $content['key'],
        'topThree' => $content['topThree'],
        'reportbackInfo' => $content['reportbackInfo'],
        'showImages' => $content['show_images'],
    ])
@endif

@if (isset($content['leaderboard']))
    @include('messages.partials._leaderboard_table', [
        'messageKey' => $content['key'],
        'leaderboard' => $content['leaderboard'],
        'reportbackInfo' => $content['reportbackInfo'],
    ])
@endif

<br><br>

{!! $content['signoff'] !!}
