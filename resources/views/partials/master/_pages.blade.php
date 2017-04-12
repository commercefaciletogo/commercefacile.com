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

            [v-cloak] {
                display: none !important;
            }

            .account{
                background: white !important;
                color: #1D305D !important;
                border-radius: 0 !important;
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
                border-bottom: solid 1px transparent;
            }

            .ui.button.post-ad:hover{
                border-bottom: solid 1px #606e8d;
            }

            .main-search{
                border: 1px solid #1d305d;
            }

            .ui.form.s{
                margin: 0 !important;
            }

            .main-search > .search-input, .main-search > .search-input:focus{
                color: #4a597d;
                border: none;
            }

            .signin.naked{
                background: none;
                color: #1d305d;
                border-radius: 0;
            }

            .signin.naked:hover{
                background: #a4acbe;
            }

            .ui.button.account{
                border-radius: 0;
                color: white;
                background: rgb(96, 110, 141);
            }

            a.ui.button.all-ads{
                background: #d1d5de;
                border-radius: 0;
            }

            a.ui.button.all-ads:hover{
                background: #d1d5de;
            }

            .main-search > .search-button, .main-search > .search-button:hover{
                background: #f79520;
                color: #606e8d;
                border-radius: 0;
            }

            .main-search > i.search.icon{
                color: #1d305d;
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
        <script>
            var categoriesUrl = "{!! LaravelLocalization::getLocalizedURL(null, '/categories') !!}";
            var locationsUrl = "{!! LaravelLocalization::getLocalizedURL(null, '/locations') !!}";
            var locale = "{!! LaravelLocalization::getCurrentLocale() !!}";
        </script>
        @yield('scripts')
    </body>
</html>