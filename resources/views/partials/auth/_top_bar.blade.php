<div class="fluid container">
    <div class="ui grid">
    
        {{--Computer & Tablet--}}
        <div class="computer tablet only sixteen wide column">
            <div style="background: #1D305D; color: white;">
                <div class="ui container">
                    <div class="ui borderless menu" style=" border-radius: 0; border: 0; box-shadow: none; background: transparent; ">
                        <a class="item" href="{{ route('home.page') }}" style="color: white;">
                            <img src="{{ asset('/img/logos/logo_w_d_white.png') }}" style="width: 250px;">
                        </a>
                        <div class="right menu">
                            <div class="item">
                                <a href="{{ route('ads.create') }}" class="ui compact button post-ad" style="">{{ trans('general.p_f_a') }}</a>
                            </div>
                            @if(auth('user')->guest())
                                <div class="item">
                                    <a href="{{ route('user.get.login') }}" class="ui compact button signin" >{{ trans('auth.sign_in') }}</a>
                                </div>
                            @elseif(starts_with(request()->route()->getName(), "user."))
                                @if(ends_with(request()->route()->getName(), ".public"))
                                    <div class="item">
                                        <a href="{{ route('user.profile', ['user_name' => auth('user')->user()->slug]) }}" class="ui compact button account" >
                                            {{ trans('general.my_account') }}
                                        </a>
                                    </div>
                                @else
                                    <div class="item">
                                        <form style="margin-bottom: 0;" class="ui inline form" method="post" action="{{ route('user.post.logout')}}">
                                            {!! csrf_field() !!}
                                            <button class="ui compact button signin" type="submit">
                                                {!! trans('auth.logout') !!}
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @else
                                <div class="item">
                                    <a href="{{ route('user.profile', ['user_name' => auth('user')->user()->slug]) }}" class="ui compact button account" >
                                        {{ trans('general.my_account') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--Mobile--}}
        <div class="mobile only sixteen wide column">
            <div style="background: #1D305D; color: white;">
                <div class="ui container">
                    <div class="ui borderless menu" style=" border-radius: 0; border: 0; box-shadow: none; background: transparent; ">
                        <a class="item" href="{{ route('home.page') }}" style="color: white;">
                            <img src="{{ asset('/img/logos/logo_acro.png') }}" alt="">
                        </a>
                        <div class="right menu">
                            @if(starts_with(request()->route()->getName(), "user."))
                                <div class="item">
                                    <a href="{{ route('ads.create') }}" class="ui button post-ad" style="">{{ trans('general.p_f_a') }}</a>
                                </div>
                                @if(auth('user')->check())
                                    <div class="item">
                                        <form style="margin-bottom: 0;" class="ui inline form" method="post" action="{{ route('user.post.logout')}}">
                                            {!! csrf_field() !!}
                                            <button style="padding: 0; background-color: transparent;" class="ui icon outline button" type="submit">
                                                <i class="icon big sign out" style="color: #ffffff"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @else
                                @if(auth('user')->guest())
                                    <div class="item">
                                        <a href="{{ route('user.get.login') }}" class="ui button signin" >{{ trans('auth.sign_in') }}</a>
                                    </div>
                                @else
                                    <a class="item" href="{{ route('user.profile', ['user_name' => auth('user')->user()->slug]) }}">
                                        <img src="{!! asset('/img/icons/user.png') !!}" alt="">
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


</div>
