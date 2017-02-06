@extends('partials.master._auth')


@section('styles')

    @yield('styles')
    
@endsection


@section('main')

    <div id="main" style="">
        <div class="ui container" style="background: #fff; border-left: 1px solid #a4acbe; border-right: 1px solid #a4acbe;">
            <div class="ui two grid" style="margin-top: 0; margin-bottom: 0;">

                {{--computer and tablet--}}
                <div class="three wide computer only column">
                    <div class="ui vertical fluid menu borderless" style="border: 0; background: transparent; border-radius: 0; box-shadow: none; border-right: 1px #a4acbe solid;">
                        <a href="{{ route('user.profile', ['user_name' => 'thomas']) }}" class="item {{ request()->route()->getName() == 'user.profile' ? "active":  '' }} ">Ads</a>
                        <a href="{{ route('user.profile.favorites', ['user_name' => 'thomas']) }}" class="item {{ request()->route()->getName() == 'user.profile.favorites' ? "active":  '' }} ">Favorites</a>
                        <a href="{{ route('user.profile.settings', ['user_name' => 'thomas']) }}" class="item  {{ request()->route()->getName() == 'user.profile.settings' ? "active":  '' }} ">Settings</a>
                    </div>
                </div>

                {{--mobile--}}
                <div class="sixteen wide tablet sixteen wide mobile only column">
                    <div class="ui three item menu" style="border: 0; background: transparent; border-radius: 0; box-shadow: none; border-bottom: 2px #a4acbe solid;">
                        <a href="{{ route('user.profile', ['user_name' => 'thomas']) }}" class="item {{ request()->route()->getName() == 'user.profile' ? "active":  '' }} ">Ads</a>
                        <a href="{{ route('user.profile.favorites', ['user_name' => 'thomas']) }}" class="item {{ request()->route()->getName() == 'user.profile.favorites' ? "active":  '' }} ">Favorites</a>
                        <a href="{{ route('user.profile.settings', ['user_name' => 'thomas']) }}" class="item  {{ request()->route()->getName() == 'user.profile.settings' ? "active":  '' }} ">Settings</a>
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