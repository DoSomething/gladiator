<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gladiator | DoSomething Competitions</title>

        <link rel="icon" type="image/ico" href="/favicon.ico?v1">

        <script src="{{ asset('/assets/vendor/forge/modernizr.js') }}"></script>

        <link rel="stylesheet" href="{{ asset('assets/vendor/forge/forge.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendor/modal/modal.css') }}">
    </head>

    <body>
        <div class="chrome">
            <div class="wrapper">

                @include('layouts.navigation')

                @include('layouts.header')

                <div class="container">
                    <div class="wrapper">
                        <div class="container__block">

                            @include('errors.status')

                            @yield('main_content')

                        </div>
                    </div>
                </div>

            </div>
        </div>

         <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="{{ asset('/assets/vendor/forge/forge.js') }}"></script>
        <script src="{{ asset('/assets/vendor/modal/modal.js') }}"></script>
    </body>

</html>

