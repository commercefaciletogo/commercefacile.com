@extends('partials.master._auth')


@section('styles')

    @yield('styles')
    
@endsection


@section('main')

    <div id="main" style="display: flex;">
        <div class="ui container" style="background: #fff; border-left: 1px solid #a4acbe; border-right: 1px solid #a4acbe;">
            <div class="ui grid" style="margin-top: 0; margin-bottom: 0;">
                <div class="three wide column">
                    <div class="ui vertical menu borderless" style="border: 0; background: transparent; border-radius: 0; box-shadow: none; border-right: 1px #a4acbe solid;">
                        <a href="{{ route('user.profile', ['user_name' => 'thomas']) }}" class="item {{ request()->route()->getName() == 'user.profile' ? "active":  '' }} ">Ads</a>
                        <a href="{{ route('user.profile.favorites', ['user_name' => 'thomas']) }}" class="item {{ request()->route()->getName() == 'user.profile.favorites' ? "active":  '' }} ">Favorites</a>
                        <a href="{{ route('user.profile.settings', ['user_name' => 'thomas']) }}" class="item  {{ request()->route()->getName() == 'user.profile.settings' ? "active":  '' }} ">Settings</a>
                    </div>
                </div>
                <div class="twelve wide column">

                    <div class="ui container">
                        
                        @yield('content')

                    </div>

                </div>
            </div>
            
            
        </div>
    </div>

@endsection