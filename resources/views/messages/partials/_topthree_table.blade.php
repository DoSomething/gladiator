@foreach ($topThree as $reportback)
    <div style="display: inline-block; margin: 0 5px;">
        <h3><span style="font-size: 14px;">In {{ $reportback['place'] }} place with {{ $reportback['quantity'] }} {{ strtolower($reportbackInfo['noun']) }}</span><br><strong>{{ $reportback['first_name'] }}</strong></h3>
        <img src="{{ $reportback['image_url'] }}" width="200" />
        <p>{{ $reportback['caption'] }}</p>
    </div>
@endforeach
