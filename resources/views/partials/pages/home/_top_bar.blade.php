<div class="ui container fluid">
    <div class="ui grid">
        <div class="computer only sixteen wide column">
            <div style="background: white; border-bottom: 2px solid #d1d5de;">
                <div class="ui container">
                    <div class="ui borderless mini menu" style="border-radius: 0; border: 0; box-shadow: none;">

                        <div class="left menu">
                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <div class="item">
                                    <a style="color: #77829d;" rel="alternate" hreflang="{{$localeCode}}" href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
                                        {{ $properties['native'] }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="right menu">
                            <div class="item">
                                <a href="{{ route('ads.create') }}" class="ui button post-ad">{{ trans('general.p_f_a') }}</a>
                            </div>
                            @if(Auth::guest())
                                <div class="item">
                                    <a href="{{ route('user.get.login') }}" class="ui button signin naked" >{{ trans('auth.sign_in') }}</a>
                                </div>
                            @else
                                <div class="item">
                                    <a class="ui button account" >{{ trans('general.my_account') }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--Tablet--}}

        <div class="tablet only sixteen wide column">
            <div style="background: white; border-bottom: 2px solid #d1d5de;">
                <div class="ui container">
                    <div class="ui borderless menu" style="border-radius: 0; border: 0; box-shadow: none;">

                        <a class="item" href="{{ route('home.page') }}" style="color: white;">
                            <img style="width: 10em;" src="/img/logo.png" alt="">
                        </a>
                        <div class="right menu">
                            <div class="item">
                                <a href="{{ route('ads.create') }}" class="ui button post-ad">{{ trans('general.p_f_a') }}</a>
                            </div>
                            @if(Auth::guest())
                                <div class="item">
                                    <a href="{{ route('user.get.login') }}" class="ui button signin naked" >{{ trans('auth.sign_in') }}</a>
                                </div>
                            @else
                                <div class="item">
                                    <a class="ui button account" >{{ trans('general.my_account') }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--Mobile--}}

        <div class="mobile only sixteen wide column">
            <div style="background: white; border-bottom: 2px solid #d1d5de;">
                <div class="ui borderless menu" style="border-radius: 0; border: 0; box-shadow: none;">
                    <a class="item" href="{{ route('home.page') }}" style="color: white;">
                        <img src="/img/logo-acro.png" alt="">
                    </a>
                    <div class="right menu">
                        @if(Auth::guest())
                            <div class="item">
                                <a href="{{ route('ads.create') }}" class="ui button post-ad">{{ trans('general.p_f_a') }}</a>
                            </div>
                        @else
                            <div class="item">
                                <a class="ui button account" >{{ trans('general.my_account') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>