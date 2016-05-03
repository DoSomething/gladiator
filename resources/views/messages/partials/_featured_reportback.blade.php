<br><br>

@include('messages.partials._reportback', [
    'type' => 'featured',
    'shoutout' => $featuredReportback['shoutout'],
    'image' => $featuredReportback['image_url'],
    'caption' => $featuredReportback['caption'],
])
