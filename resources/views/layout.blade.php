<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{ Html::style('css/app.css') }}
        {{ Html::style('css/signature_pad.css') }}
        {{ Html::style('css/custom.css') }}
        {{ Html::style('css/datatable.min.css') }}
        {{ Html::style('css/datatables.bootstrap.min.css') }}

        {{ Html::favicon('images/Horsepower_favicon.png') }}

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
                    <a class="navbar-brand" href={{route('home')}}><img style="height:100%" src={{asset('images/Horsepower.png')}} /></a>
                </div>
            </nav>
        </div>

        @yield('content')

        {{ Html::script('js/signature_pad.js') }}
        {{ Html::script('js/sig_app.js') }}
        {{ Html::script('js/app.js') }}
        {{ Html::script('js/jquery.mask.js') }}
        {{ Html::script('js/custom.js') }}
        {{ Html::script('js/datatable.min.js') }}
        {{ Html::script('js/datatables.bootstrap.min.js') }}

        @yield('scripts')

    </body>
</html>
