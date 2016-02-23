<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>DoSomething Competitions</title>

        <link rel="icon" type="image/ico" href="/favicon.ico?v1">

        <script src="{{ asset('/assets/vendor/forge/modernizr.js') }}"></script>

        <link rel="stylesheet" href="{{ asset('assets/vendor/forge/forge.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendor/modal/modal.css') }}">
    </head>

    <body>
        <div class="chrome">
            <div class="wrapper">

                <div class="container">

                    <!-- TODO: move to partial, will be used to show any messages -->
                    @if (Session::has('status'))
                        <div>{{ Session::get('status') }}</div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif

                    @yield('main_content')

                </div>

                {{-- @include('layouts.navigation') // Commenting out for now. --}}

            </div>
        </div>

        <script src="{{ asset('/assets/vendor/forge/forge.js') }}"></script>
        <script src="{{ asset('/assets/vendor/modal/modal.js') }}"></script>
    </body>

</html>

