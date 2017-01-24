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

        /*div#main > div.ui.container {
            display: flex;
            justify-content: center;
            align-items: stretch;
        }*/

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
            color: #fff;
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

        .ui.submit.button.fluid, .ui.submit.button{
            background: #4a597d;
            color: #fff;
        }

        .ui.submit.button.fluid:hover, .ui.submit.button:hover{
            background: #1d305d;
            color: #fff;
        }

        .ui.form .fields .field .ui.input input, .ui.form .field .ui.input input, .ui.form textarea{
            color: #4a597d;
        }

        .ui.form .fields .field .ui.input input:focus, .ui.form .field .ui.input input:focus, .ui.form textarea:focus{
            border-color: #4a597d;
            color: #4a597d;
        }

        .ui.button.fluid.auth.action{
            background: #f79520;
            color: #fff;
        }

        .ui.button.fluid.auth.action:hover{
            background: #f8aa4c;
        }

        .ui.vertical.menu .item{
            color: #a4acbe;
        }

        .ui.vertical.menu .active.item, .ui.vertical.menu .item:hover, .ui.vertical.menu .active.item:hover{
            background: #f5f6f8;
            color: #33446d;
        }

         .ui.vertical.menu .active.item:hover{
             cursor: default;
         }

        .ui.vertical.menu > .item:first-child, .ui.vertical.menu > .item:last-child, .ui.vertical.menu > .active.item:last-child, .ui.vertical.menu > .active.item:first-child{
            border-radius: 0;
        }

        .ui.divider {
            color: #33446d;
        }

    </style>
    @yield('styles')
</head>
<body>
@include('partials.auth._top_bar')

<div class="ui container fluid" style="background: #f5f6f8; justify-content: center; align-items: stretch;">
    @yield('main')
</div>

@include('partials._footer')

<script src="{!! elixir('js/vendors.js') !!}"></script>
@yield('scripts')

</body>
</html>