<html>
<head>
    <title>Commercefacile.com</title>
    <link rel="stylesheet" href="{!! elixir('css/vendors.css') !!}">
    <style>
        body{
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }
        body > div.ui.container.fluid{
            flex: 1;
        }

        .ui.vertical.footer.segment {
            border-top: .4em solid #33446d;
        }

        .ui.vertical.footer.segment a{
            color: #77829d;
        }

        .ui.vertical.footer.segment a:hover{
            color: #33446d;
        }

        .ui.menu .item .ui.button.signin{
            background: transparent;
            color: #33446d;
        }

        .ui.menu .item .ui.button.new{
            background: #F79520; color: white;
        }

        .ui.menu .item .ui.button.new:hover{
            background: #f8aa4c;
        }

        .ui.menu .item .ui.button.signin:hover{
            background: #33446d;
            color: #fff;
        }

        .ui.vertical.footer.segment .ui.header{
            color: #4a597d;
        }

        .ui.submit.button.fluid{
            background: #4a597d;
            color: #fff;
        }

        .ui.submit.button.fluid:hover{
            background: #1d305d;
            color: #fff;
        }

        .ui.form .fields .field .ui.input input, .ui.form .field .ui.input input{
            color: #4a597d;
        }

        .ui.form .fields .field .ui.input input:focus, .ui.form .field .ui.input input:focus{
            border-color: #4a597d;
        }

        .ui.button.fluid.auth.action{
            background: #f79520;
            color: #fff;
        }

        .ui.button.fluid.auth.action:hover{
            background: #f8aa4c;
        }
    </style>
    @yield('styles')
</head>
<body>
@include('partials.auth._top_bar')

<div class="ui container fluid">
    @yield('main')
</div>

@include('partials._footer')

<script src="{!! elixir('js/vendors.js') !!}"></script>
@yield('scripts')

</body>
</html>