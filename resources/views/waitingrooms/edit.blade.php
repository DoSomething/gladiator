@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Waiting Rooms',
        'subtitle' => 'Edit waiting room ' . $room->id
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block -narrow">
                <form method="POST" action="{{ route('waitingrooms.update', $room->id) }}">
                    {{ method_field('PATCH') }}

                    @include('waitingrooms.partials._form_waitingrooms')
                </form>
            </div>
        </div>
    </div>

@stop
