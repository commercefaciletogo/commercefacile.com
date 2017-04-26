@extends('partials.master._auth')


@section('styles')

    <style>
        .bottom-bar{
            border-bottom: 2px solid rgb(209, 213, 222) !important;
        }
    </style>

    @yield('styles')
    
@endsection


@section('main')

    <div id="main" style="">
        <div class="ui container" style="background: #fff; border-left: 1px solid #a4acbe; border-right: 1px solid #a4acbe; min-height: 65vh;">

            @yield('meta')

            <div class="ui two grid" style="margin-top: 0; margin-bottom: 0;">

                {{--computer and tablet--}}
                <div class="three wide computer only column">
                    <div class="ui vertical fluid menu borderless" style="border: 0; background: transparent; border-radius: 0; box-shadow: none; border-right: 1px #a4acbe solid;">
                        @include('partials.profile._menu')
                    </div>
                </div>

                {{--mobile--}}
                <div class="sixteen wide tablet sixteen wide mobile only column">
                    <div class="ui three item menu" style="border: 0; background: transparent; border-radius: 0; box-shadow: none; border-bottom: 2px #a4acbe solid;">
                        @include('partials.profile._menu')
                    </div>
                </div>

                <div class="thirteen wide computer sixteen wide tablet sixteen wide mobile column">
                    <div class="ui container">
                        @yield('content')
                    </div>

                </div>
            </div>
            
            
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        var authorId = "{!! auth('user')->user()->uuid !!}";
        $(function(){
            $('#process').progress();
        });
    </script>
    @yield('sub_scripts')
@endsection