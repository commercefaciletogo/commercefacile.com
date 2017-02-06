<html>
    <head>
        <title>Commercefacile.com</title>
        <link rel="stylesheet" href="{!! elixir('css/vendors.css') !!}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <style>
            html{
                height: 100%;
            }
            body{
                display: flex;
                min-height: 100vh;
                flex-direction: column;
            }
            body > div{
                flex: 1;
            }

            .ui.button.menu-signin{
                background: none;
                color: #1d305d;
            }

            .ui.button.menu-signin:hover{}

            .ui.vertical.footer.segment a{
                color: #77829d;
            }

            .ui.vertical.footer.segment a:hover{
                color: #33446d;
            }

            .ui.vertical.footer.segment .ui.header{
                color: #4a597d;
            }

            .ui.button.post-ad, .ui.button.large.post-ad{
                border-radius: 0;
                color: #606e8d;
                background: #F79520;
            }

            .ui.button.post-ad:hover{
                border-bottom: solid 1px #606e8d;
            }

            @media only screen and (max-width: 767px){
                .ui.container{
                    margin-right: 0 !important;
                    margin-left: 0 !important;
                }
            }
        </style>

        @yield('styles')
    </head>
    <body>
        <div class="ui fluid container"  style="background: #e8eaee;" id="root">
            @yield('main-menu')
            @yield('main')
        </div>

        @include('partials._footer')

        <script src="{!! elixir('js/vendors.js') !!}"></script>
        @yield('scripts')
    </body>
</html>