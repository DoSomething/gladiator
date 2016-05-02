@foreach ($topThree as $index => $reportback)
    {{-- Update emails. --}}
    @if ($messageKey !== 2)
      @include('messages.partials._reportback', [
          'messageKey' => $messageKey,
          'place' => $reportback['place'],
          'quantity' => $reportback['quantity'],
          'reportbackNoun' => $reportbackInfo['noun'],
          'firstName' => $reportback['first_name'],
          'image' => $reportback['image_url'],
          'caption' => $reportback['caption'],
      ])
    {{-- Final leaderboard message. --}}
    @else
      @include('messages.partials._reportback', [
          'messageKey' => $messageKey,
          'place' => $reportback['place'],
          'prize' => $reportback['prize_copy'],
          'quantity' => $reportback['quantity'],
          'reportbackNoun' => $reportbackInfo['noun'],
          'firstName' => $reportback['first_name'],
          'image' => $reportback['image_url'],
          'caption' => $reportback['caption'],
      ])
    @endif
@endforeach
