@extends('layouts.master')

@section('main_content')

    @include('layouts.header',[
        'title' => 'Settings',
        'subtitle' => 'Default Messages Customization'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block -narrow">
                <h2 class="heading">All Messages</h2>

                <form method="POST" action="{{ route('settings.messages.update') }}">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}

                    @foreach($messages as $message)
                        {{-- @TODO: move out of contests so this partial is more universal. --}}
                        @include('contests.partials._form_contest_messaging')
                    @endforeach

                    <input type="submit" class="button" value="Submit" />
                </form>
            </div>
        </div>
    </div>

@stop
