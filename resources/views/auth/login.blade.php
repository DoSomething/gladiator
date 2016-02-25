@extends('layouts.master')

@section('main_content')

    @include('layouts.header', [
        'title' => 'Gladiator',
        'subtitle' => 'Please login to continue.'
    ])

    <div class="container -padded">
        <div class="wrapper">
            <div class="container__block -narrow">

                @include('layouts.errors')

                <form method="POST" action="/auth/login" class="form-signin">
                    {{ csrf_field() }}

                    <div class="form-item -padded">
                        <label class="field-label" for="email">Email</label>
                        <input type="text" name="email" id="email" class="text-field" placeholder="kallark&#64;dosomething.org" required>
                    </div>

                    <div class="form-item -padded">
                        <label class="field-label" for="password">Password</label>
                        <input type="password" name="password" id="password" class="text-field" placeholder="••••••" required>
                    </div>

                    <input type="submit" class="button" value="Log In" />
                </form>

            </div>
        </div>
    </div>

@stop
