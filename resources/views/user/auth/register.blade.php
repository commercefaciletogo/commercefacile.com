@extends('partials.master._auth')

@section('styles')
    <style>
        div.field i{
            color: #4a597d;
        }

        div.field.error i{
            color: #9F3A38;
        }

        .fade-transition {
            transition: opacity 0.2s ease;
        }

        .fade-enter, .fade-leave {
            opacity: 0;
        }
    </style>
@endsection

@section('main')

    <div id="main" class="ui container">
        <div class="ui container center aligned" style="padding-top: 1.5em; padding-bottom: 5em; background: transparent;">
            <h2 class="header"  style="margin-bottom: 1em; color: #33446d;">{{ trans('auth.register_header') }}</h2>

            <div class="ui two column centered grid">
                <div class="twelve wide computer fifteen wide tablet sixteen wide mobile column" style="">
                    <div class="ui two column grid">
                        <div class="eight wide computer eight wide tablet sixteen wide mobile column">
                            <div style="margin-left: 1.5em; margin-right: 1.5em;">

                                <form class="ui form {{ $errors->any() ? ' error' : '' }}" method="post" action="{{ route('user.post.register') }}">
                                    {{ csrf_field() }}
                                    <div class="field {{ $errors->has('name') ? 'error' : '' }}">
                                        <div class="ui left icon input">
                                            <input type="text" placeholder="{{ trans('general.full_name') }}" value="{{ old('name') }}" name="name">
                                            <i class="user icon"></i>
                                        </div>
                                        @if($errors->has('name'))
                                            <div class="ui red pointing label" style="background: white; color: #33446d; font-size: .8em; font-weight: 300;">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="field {{ $errors->has('phone') ? 'error' : '' }}">
                                        <div class="ui right labeled input">
                                            <div class="ui basic label" style="color: #4a597d;">+228</div>
                                            <input type="tel" name="phone" placeholder="{{ trans('general.phone_number') }}" value="{{ old('phone') }}">
                                        </div>
                                        @if($errors->has('phone'))
                                            <div class="ui red pointing label" style="background: white; color: #33446d; font-size: .8em; font-weight: 300;">
                                                {{ $errors->first('phone') }}
                                            </div>
                                        @else
                                            <div class="ui pointing label" style="background: white; color: #33446d; font-size: .8em; font-weight: 300;">
                                                {{ trans('auth.phone_hint') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="field {{ $errors->has('password') ? 'error' : '' }}">
                                        <div class="ui left icon input">
                                            <input type="password" name="password" placeholder="{{ trans('auth.password') }}">
                                            <i class="lock icon"></i>
                                        </div>
                                        @if($errors->has('password'))
                                            <div class="ui red pointing label" style="background: white; color: #33446d; font-size: .8em; font-weight: 300;">
                                                {{ $errors->first('password') }}
                                            </div>
                                        @else
                                            <div class="ui pointing label" style="background: white; color: #33446d; font-size: .8em; font-weight: 300;">
                                                {{ trans('auth.password_hint') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="field {{ $errors->has('password_confirmation') ? 'error' : '' }}">
                                        <div class="ui left icon input">
                                            <input type="password" name="password_confirmation" placeholder="{{ trans('auth.confirm_password') }}">
                                            <i class="lock icon"></i>
                                        </div>
                                        @if($errors->has('password_confirmation'))
                                            <div class="ui red pointing label" style="background: white; color: #33446d; font-size: .8em; font-weight: 300;">
                                                {{ $errors->first('password_confirmation') }}
                                            </div>
                                        @endif
                                    </div>
                                    <button type="submit" class="ui submit button fluid">{{ trans('auth.register') }}</button>
                                </form>

                                <div class="ui horizontal divider" style="text-transform: capitalize; color: #77829d;">
                                    {{ trans('auth.already') }}
                                </div>
                                <a href="{{ route('user.get.login') }}" class="ui button fluid auth action">
                                    {{ trans('auth.sign_in') }}
                                </a>
                            </div>
                        </div>

                        <div class="computer tablet only column">
                            <h3 class="header" style="margin-top: 1em; color: #33446d;">{{ trans('auth.new_to') }}</h3>
                            <h5 class="header" style="margin-top: 1em; color: #33446d;"><i>{{ trans('auth.let_you') }}</i></h5>
                            <div class="ui relaxed items" style="color: #33446d;">
                                <div class="item" style="margin-bottom: 3em;">
                                    <div class="ui mini image">
                                        <img src="{{ asset('/img/icons/price_tag_512.png') }}">
                                    </div>
                                    <div class="middle aligned content">
                                        {{ trans('auth.post_your_ads') }}
                                    </div>
                                </div>
                                <div class="item" style="margin-bottom: 3em;">
                                    <div class="ui mini image">
                                        <img src="{{ asset('/img/icons/favorite_two.svg') }}">
                                    </div>
                                    <div class="middle aligned content">
                                        {{ trans('auth.favorite_and_later') }}
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="ui mini image">
                                        <img src="{{ asset('/img/icons/manage_ads_512.png') }}">
                                    </div>
                                    <div class="middle aligned content">
                                        {{ trans('auth.manage_and_view') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

@endsection
