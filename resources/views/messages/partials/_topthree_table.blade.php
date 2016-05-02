@foreach ($topThree as $index => $reportback)
    <div style="display: inline-block; margin: 0 5px;">
        @if ($index === 0)
          {{-- Leaderboard update 1 and 2 --}}
          @if ($messageKey !== 2)
              <h3><span style="font-size: 14px;">Our current leader with {{ $reportback['quantity'] }} {{ strtolower($reportbackInfo['noun']) }}... </span><br><strong>{{ $reportback['first_name'] }}</strong></h3>
          {{-- Final leaderboard update --}}
          @else
              <h3><span style="font-size: 14px;">Our winner with {{ $reportback['quantity'] }} {{ strtolower($reportbackInfo['noun']) }}... </span><br><strong>{{ $reportback['first_name'] }}</strong></h3>
          @endif
        @else
            <h3><span style="font-size: 14px;">In {{ $reportback['place'] }} place with {{ $reportback['quantity'] }} {{ strtolower($reportbackInfo['noun']) }}</span><br><strong>{{ $reportback['first_name'] }}</strong></h3>
        @endif

        <img src="{{ $reportback['image_url'] }}" width="200" />

        <p>{{ $reportback['caption'] }}</p>
    </div>
@endforeach
