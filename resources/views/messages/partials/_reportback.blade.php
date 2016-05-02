@if ($type === 'topThree')
    <p>
        @if ($place === '1st')
            @if ($messageKey !== 2)
                Our current leader with {{ $quantity }} {{ strtolower($reportbackNoun) }}...
            @else
                Our winner, with {{ $quantity }} {{ strtolower($reportbackNoun) }}...
            @endif
        @else
            In {{ $place }} place with {{ $quantity }} {{ strtolower($reportbackNoun) }}...
        @endif

        @if ($messageKey === 2)
            <br>

            {{ $prize }}
        @endif

        <br>

        <strong>
            {{ $firstName or '' }}
        </strong>
    </p>
@elseif ($type === 'featured')
    <p>{{ $shoutout or '' }}</p>
@endif

<img src="{{ $image }}" width="200" />

<p>"<em>{{ $caption }}</em>"</p>
