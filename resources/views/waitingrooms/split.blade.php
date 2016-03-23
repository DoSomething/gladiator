@extends('layouts.master')

@section('main_content')

    @include('layouts.header',[
        'title' => 'Waiting Room Banana Split'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block -narrow">
                <form method="POST" action="{{ route('split', $room->id) }}">
                    {{ method_field('POST') }}
                    {{ csrf_field() }}

                    <input type="submit" class="button" value="Split" />
                </form>
            </div>
        </div>
    </div>
    @foreach($split as $key => $competition)
        @include('users.partials._table_users', ['users' => $competition, 'role' => 'Competition ' . ($key + 1) . ' : ' . $competition->count() . ' users'])
    @endforeach
@stop
