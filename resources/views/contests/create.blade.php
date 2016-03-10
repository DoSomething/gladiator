@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Contests',
        'subtitle' => 'Add a new contest'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block -narrow">
                <form method="POST" action="{{ route('contests.store') }}">
                    @include('contests.partials._form_contest')
                </form>
            </div>
        </div>
    </div>

@stop
