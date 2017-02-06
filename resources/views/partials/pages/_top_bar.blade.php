<div class="ui container fluid">
    <div class="ui grid">
        <div class="computer only sixteen wide column">
            <div style="background: white; border-bottom: 2px solid #d1d5de;">
                <div class="ui container">
                    <div class="ui borderless huge menu" style="border-radius: 0; border: 0; box-shadow: none;">

                        <a class="item" href="{{ route('home.page') }}" style="color: white;">
                            <img style="width: 10em;" src="{{ asset('/img/logos/logo_w_n.png') }}" alt="">
                        </a>

                        <div class="right menu">
                            <div class="item">
                                <a href="{{ route('ads.create') }}" class="ui large button post-ad">{{ trans('general.p_f_a') }}</a>
                            </div>
                            @if(Auth::guest())
                                <div class="item">
                                    <a href="{{ route('user.get.login') }}" class="ui button menu-signin" >{{ trans('auth.sign_in') }}</a>
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
                            <img style="width: 10em;" src="{{ asset('/img/logos/logo_w_n.png') }}" alt="">
                        </a>
                        <div class="right menu">
                            <div class="item">
                                <a href="{{ route('ads.create') }}" class="ui button post-ad">{{ trans('general.p_f_a') }}</a>
                            </div>
                            @if(Auth::guest())
                                <div class="item">
                                    <a href="{{ route('user.get.login') }}" class="ui button menu-signin" >{{ trans('auth.sign_in') }}</a>
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
                        <img src="{{ asset('/img/logos/logo_acro.png') }}" alt="">
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