<h2 class="heading -banner">Top Three Reportbacks</h2>

@foreach ($topThree as $reportback)
    <div style="display: inline-block; margin: 0 5px;">
        <h3>In {{ $reportback['place'] }} place with {{ $reportback['quantity'] }} {{ strtolower($reportbackInfo['noun']) }}</h3>
        <h4 style="font-size: 18px;"><strong>{{ $reportback['first_name'] }}</strong></h4>
        <img src="{{ $reportback['image_url'] }}" width="200" />
        <p>{{ $reportback['caption'] }}</p>
    </div>
@endforeach
