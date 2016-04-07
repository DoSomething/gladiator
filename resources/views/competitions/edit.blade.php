@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Competitions',
        'subtitle' => 'Edit competition ' . $competition->id
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                @include('competitions.partials._form_competitions')
            </div>
        </div>
    </div>

@stop
