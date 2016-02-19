@extends('layouts.master')

@section('main_content')

    @include('layouts.header', ['header' => 'Gladiator', 'subtitle' => 'Please login to continue.'])

    <div class="container -padded">
        <div class="wrapper">
            <div class="container__block -narrow">

                <form method="POST" action="/auth/login" class="form-signin">
                    {{ csrf_field() }}

                    <div class="form-item">
                        <label class="field-label">Email</label>
                        <input type="text" class="text-field" placeholder="kallark@dosomething.org">
                    </div>

                    <div class="form-item">
                        <label class="field-label">Password</label>
                        <input type="password" class="text-field" placeholder="•••••••">
                    </div>

                    <a class="button">Login</a>

                </form>

            </div>
        </div>
    </div>

@stop
