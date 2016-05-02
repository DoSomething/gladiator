<br><br>

@foreach ($topThree as $index => $reportback)
  <div style="display: inline-block; margin: 0 5px;">
    @include('messages.partials._reportback', [
        'type' => 'topThree',
        'messageKey' => $messageKey,
        'place' => $reportback['place'],
        'prize' => $reportback['prize_copy'],
        'quantity' => $reportback['quantity'],
        'reportbackNoun' => $reportbackInfo['noun'],
        'firstName' => $reportback['first_name'],
        'image' => $reportback['image_url'],
        'caption' => $reportback['caption'],
    ])
  </div>
@endforeach
