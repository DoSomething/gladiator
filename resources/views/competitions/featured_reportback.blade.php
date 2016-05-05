@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Featured Reportback',
        'subtitle' => 'For Message "' . $message->label . '" on competition ' . $competition->id
    ])

     <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <h2 class="heading -banner">Edit Featured reportback</h2>
                <form method="POST" action="{{ route('competitions.updateFeaturedReportback', ['competition' => $competition->id, 'message' => $message->id]) }}">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}

                    @include('layouts.errors')

                    <div class="form-item -padded">
                        <label class="field-label" for="contest_id">Reportback ID:</label>
                        <input type="text" name="reportback_id" id="reportback_id" class="text-field" value="{{ $competition->reportback_id or old('reportback_id') }}" />
                    </div>

                    <div class="form-item -padded">
                        <label class="field-label" for="contest_id">Reportback Item ID:</label>
                        <input type="text" name="reportback_item_id" id="reportback_item_id" class="text-field" value="{{ $competition->reportback_item_id or old('reportback_item_id') }}" />
                    </div>

                    <div class="form-item -padded">
                        <label class="field-label" for="contest_id">Shoutout:</label>
                        <input type="text" name="shoutout" id="shoutout" class="text-field" value="{{ $competition->shoutout or old('shoutout') }}" />
                    </div>

                    <div class="form-item -padded">
                        <input type="submit" class="button" value="Submit" />
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop
