<html>
<head>
    <title>Commercefacile.com</title>
    @if(App::environment('production'))
        @include('partials.production.css')
    @else
        <link rel="stylesheet" href="{!! elixir('css/vendors.css') !!}">
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{!! csrf_token() !!}">
    <meta name="locale" content="{!! LaravelLocalization::getCurrentLocale() !!}">
    @include('partials.favico')
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
    @include('partials.admin._top_bar_menu')
    <div class="ui container">
        @yield('main')
    </div>
</div>

@if(App::environment('production'))
    @include('partials.production.js')
@else
    <script src="{!! elixir('js/vendors.js') !!}"></script>
@endif
<script>
    var adsStatusUrl = "{{ route('api.ads.status') }}";
    var changePasswordUrl = "{{ route('employee.pass.change') }}";
    var locale = "{!! LaravelLocalization::getCurrentLocale() !!}";
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.min.js"></script>
<script src="{{ asset('js/admin-page-layout.js') }}"></script>
@yield('scripts')
</body>
</html>