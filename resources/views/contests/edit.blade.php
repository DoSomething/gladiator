@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Contests',
        'subtitle' => 'Edit contest ' . $contest->id
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <form method="POST" action="{{ route('contests.update', $contest->id) }}">
                    {{ method_field('PATCH') }}

                    @include('contests.partials._form_contest')
                </form>
            </div>
        </div>
    </div>

@stop
