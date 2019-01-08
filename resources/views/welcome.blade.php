<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            <img src="../svg/logo.png" alt="Stafflauncher logo">
        </title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Dancing+Script|Nunito" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,400,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet"/>
        <link href="{{URL::asset('css/app.css')}}" rel="stylesheet" type="text/css">
        <link href="{{URL::asset('js/app.js')}}" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="app">
            <div class="flex-center position-ref full-height">
                @if (Route::has('login'))
                    <div class="top-right links">
                        @auth
                            <a href="{{ url('/home') }}">Home</a>
                        @else
                            <a href="{{ route('login') }}">Login</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif

                <div class="content">
                    <div class="main-title title m-b-md">
                        <img src="../svg/logo.png" alt="Stafflauncher logo">
                    </div>
                    <p class="subtitle"></p>
                    <p class="subsubtitle">
                            Powered by <img class="powered" src="../svg/logo_white_beta.svg" alt="Car-info logo">
                    </p>
                </div>
            </div>
        </div>
    </body>

    <footer>
        <div class="text-center">
                
        </div>
    </footer>
</html>
