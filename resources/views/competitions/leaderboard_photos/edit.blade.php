@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Leaderboard Photos',
        'subtitle' => 'For Message "' . $message->label . '" on competition ' . $competition->id
    ])

     <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <h2 class="heading -banner">Edit Leadeboard Photos</h2>
                <form method="POST" action="{{ route('competitions.updateLeaderboardPhotos', ['competition' => $competition->id, 'message' => $message->id]) }}">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}

                    @include('layouts.errors')

                    @foreach ($topThree as $index => $reportback)
                    <div class="form-item -padded">
                        <h2>{{$reportback['place']}} Place: {{$reportback['first_name']}}</h2>
                        <label class="field-label" for="user_id_{{$index}}">User ID:</label>
                        <input type="text" name="user_id_{{$index}}" id="user_id_{{$index}}" class="text-field" value="{{ $reportback['user_id']}}" readonly/>
                    </div>

                    <div class="form-item -padded">
                        <label class="field-label" for="reportback_id_{{$index}}">Reportback ID:</label>
                        <input type="text" name="reportback_id_{{$index}}" id="reportback_id_{{$index}}" class="text-field" value="{{ $reportback['reportback_id']}}" readonly/>
                    </div>

                    <div class="form-item -padded">
                        <label class="field-label" for="reportback_item_id_{{$index}}">Reportback Item ID:</label>
                        <input type="text" name="reportback_item_id_{{$index}}" id="reportback_item_id_{{$index}}" class="text-field" value="{{ $photos[$index]['reportback_item_id'] or '' }}" />
                    </div>
                    @endforeach

                    <div class="form-item -padded">
                        <input type="submit" class="button" value="Submit" />
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop
