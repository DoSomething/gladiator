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

                    <div class="form-item -padded">
                        <label class="field-label" for="contest_id">Reportback ID:</label>
                        <input type="text" name="reportback_id" id="reportback_id" class="text-field" value="{{ $reportback->reportback_id or old('reportback_id') }}" />
                    </div>

                    <div class="form-item -padded">
                        <label class="field-label" for="contest_id">Reportback Item ID:</label>
                        <input type="text" name="reportback_item_id" id="reportback_item_id" class="text-field" value="{{ $reportback->reportback_item_id or old('reportback_item_id') }}" />
                    </div>

                    <div class="form-item -padded">
                        <input type="submit" class="button" value="Submit" />
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop
