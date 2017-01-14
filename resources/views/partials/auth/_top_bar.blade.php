<div class="fluid container" style="background: #e8eaee;">
    <div class="ui container">
        <div class="ui borderless menu" style="
        border-radius: 0;
        border: 0;
        box-shadow: none;
        background: transparent;
    ">
            <a class="item" href="{{ route('home.page') }}">
                {{--<img src="" alt="">--}}
                LOGO
            </a>
            <div class="right menu">
                <div class="item">
                    <a href="{{ route('ads.create') }}" class="ui button new" style="">Post Free Ad</a>
                </div>
                @if(Auth::guest())
                    <div class="item">
                        <a href="{{ route('user.get.login') }}" class="ui button signin" >Sign in</a>
                    </div>
                @else
                    <div class="item">
                        <a class="ui button account" >My Account</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>