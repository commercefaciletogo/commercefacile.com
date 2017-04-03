<html>
<head>
    <title>Commercefacile.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{!! csrf_token() !!}">
    <link rel="stylesheet" href="{!! elixir('css/vendors.css') !!}">
    <style>
        html{
            height: 100%;
        }
        body{
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }
        body > div.ui.container.fluid{
            flex: 1;
        }

        [v-cloak] {
            display: none !important;
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
            border-radius: 0;
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

        .ui.submit.button.fluid, .ui.fluid.button{
            background: #4a597d;
            color: #fff;
        }

        .ui.submit.button.fluid:hover, .ui.fluid.button:hover{
            background: #1d305d;
            color: #fff;
        }

        .ui.form .fields .field .ui.input input, .ui.form .field .ui.input input, .ui.form textarea, textarea, input{
            color: #4a597d;
        }

        .ui.form .fields .field .ui.input input:focus, .ui.form .field .ui.input input:focus, .ui.form textarea:focus, textarea:focus, input:focus{
            border-color: #4a597d;
            color: #4a597d;
        }

        .account{
            background: white !important;
            color: #1D305D !important;
            border-radius: 0 !important;
        }

        .ui.button.fluid.auth.action{
            background: #f79520;
            color: #fff;
            border-radius: 0;
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
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
        }


    </style>
    @yield('styles')
</head>
<body>

<div class="ui container fluid" style="background: #e8eaee;">
    @yield('main')
</div>
<script src="{!! elixir('js/vendors.js') !!}"></script>
@yield('scripts')

</body>
</html>