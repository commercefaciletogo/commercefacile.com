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

    <div style="">
        <div class="ui container" style="background: #fff; border-left: 1px solid #a4acbe; border-right: 1px solid #a4acbe; min-height: 65vh;">

            @yield('meta')

            <div id="main" class="ui two grid" style="margin-top: 0; margin-bottom: 0;">

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.min.js"></script>
    <script>
        var authorId = "{!! auth('user')->user()->uuid !!}";
        $(function(){
            $('#process').progress();
        });
    </script>
    @if(App::environment('production'))
        <script src="https://b86068563707f1548c7c-cc73bb3144250bf95e4a0690bc25f5d2.ssl.cf5.rackcdn.com/assets/profile-meta.js"></script>
    @else
        <script src="{{ asset('js/profile-meta.js') }}"></script>
    @endif
    @yield('sub_scripts')
@endsection