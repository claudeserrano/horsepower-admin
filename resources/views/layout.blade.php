<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/signature_pad.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/custom.css') }}">

        <title>@yield('title')</title>

    </head>
    <body>

        <div class="row">
            <nav class = "navbar navbar-inverse navbar-fixed-top">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#topMenu" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href={{route('dashboard')}}><img style="height:100%" src={{asset('img/Horsepower.png')}} /></a>
                </div>
            </nav>
        </div>

        @yield('content')

        {{ Html::script('js/signature_pad.js') }}
        {{ Html::script('js/sig_app.js') }}
        {{ Html::script('js/app.js') }}
        {{ Html::script('js/jquery.mask.js') }}
        {{ Html::script('js/custom.js') }}

        <script>
            var canvas = document.querySelector("canvas");

            var signaturePad = new SignaturePad(canvas);

            function signature(){
                var hidden = document.getElementById('uri');
                hidden.value = signaturePad.toDataURL();
            }            
        </script>

        @yield('scripts')




    </body>
</html>
