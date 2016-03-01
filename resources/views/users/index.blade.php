@extends('layouts.master')

@section('main_content')

    @include('layouts.header',[
        'title' => 'Users'
    ])

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <a class="button" href="{{ route('users.create') }}">Add User</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="wrapper">
            <div class="container__block">
                <table class="table">
                    <thead>
                        <tr class="table__header">
                            <th class="table__cell">ID</th>
                            <th class="table__cell">First Name</th>
                            <th class="table__cell">Last Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="table__row">
                                <td class="table__cell">{{ $user->id }}</td>
                                <td class="table__cell">&hellip;</td>
                                <td class="table__cell">&hellip;</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop
