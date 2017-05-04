<div class="ui container fluid">
    <div class="ui grid">
        <div class="computer only sixteen wide column">
            <div style="background: #1D305D; border-bottom: 2px solid #d1d5de;">
                <div class="ui container">
                    <div class="ui borderless mini menu" style="border-radius: 0; border: 0; box-shadow: none; background: #1D305D;">

                        <div class="left menu">
                            @foreach(Localization::getSupportedLocales() as $key => $locale)
                                <div class="item {{ localization()->getCurrentLocale() == $key ? 'active' : '' }}">
                                    <a style="color: #77829d;"
                                       rel="alternate"
                                       hreflang="{{ $key }}"
                                       href="{{ localization()->getLocalizedURL($key)  }}">
                                        {{ $locale->native() }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="right menu">
                            <div class="item">
                                <a href="{{ route('ads.create') }}" class="ui button post-ad">{{ trans('general.p_f_a') }}</a>
                            </div>
                            @if(Auth::guard('user')->guest())
                                <div class="item">
                                    <a style="color: white;" href="{{ route('user.get.login') }}" class="ui button signin naked" >{{ trans('auth.sign_in') }}</a>
                                </div>
                            @else
                                <div class="item">
                                    <a href="{{ route('user.profile', ['user_name' => Auth::guard('user')->user()->slug]) }}"
                                       class="ui button account" >{{ trans('general.my_account') }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--Tablet--}}

        <div class="tablet only sixteen wide column">
            <div style="background: #1D305D; border-bottom: 2px solid #d1d5de;">
                <div class="ui container">
                    <div class="ui borderless menu" style="border-radius: 0; border: 0; box-shadow: none; background: #1D305D;">

                        <a class="item" href="{{ route('home.page') }}" style="color: white;">
                            <img style="" src="{!! asset('/img/logos/logo_acro.png') !!}" alt="">
                        </a>
                        <div class="right menu">
                            <div class="item">
                                <a href="{{ route('ads.create') }}" class="ui button post-ad">{{ trans('general.p_f_a') }}</a>
                            </div>
                            @if(auth('user')->guest())
                                <div class="item">
                                    <a href="{{ route('user.get.login') }}" class="ui button signin naked" >{{ trans('auth.sign_in') }}</a>
                                </div>
                            @else
                                <div class="item">
                                    <a href="{{ route('user.profile', ['user_name' => auth('user')->user()->slug]) }}"
                                       class="ui button account" >{{ trans('general.my_account') }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--Mobile--}}

        <div class="mobile only sixteen wide column">
            <div style="background: #1D305D; border-bottom: 2px solid #d1d5de;">
                <div class="ui borderless menu" style="border-radius: 0; border: 0; box-shadow: none; background: #1D305D;">
                    <a class="item" href="{{ route('home.page') }}" style="color: white;">
                        <img src="{!! asset('/img/logos/logo_acro.png') !!}" alt="">
                    </a>
                    <div class="right menu">
                        <div class="item">
                            <a href="{{ route('ads.create') }}" class="ui button post-ad" style="">{{ trans('general.p_f_a') }}</a>
                        </div>
                        @if(auth('user')->guest())
                            <a class="item" href="{{ route('user.get.login') }}">
                                <i class="icon big sign in" style="color: rgb(96, 110, 141);"></i>
                            </a>
                        @else
                            <a class="item" href="{{ route('user.profile', ['user_name' => auth('user')->user()->slug]) }}">
                                <img src="{!! asset('/img/icons/user.png') !!}" alt="">
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>