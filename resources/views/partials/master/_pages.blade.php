<html>
    <head>
        <title>Commercefacile.com</title>
        <link rel="stylesheet" href="{!! elixir('css/vendors.css') !!}">

        @yield('styles')
    </head>
    <body>
        <div class="ui container fluid">
            @yield('main-menu')

            @yield('main')
        </div>

        <script src="{!! elixir('js/vendors.js') !!}"></script>
        @yield('scripts')
    </body>
</html>