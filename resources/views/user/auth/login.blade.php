@extends('partials.master._auth')

@section('styles')
    <style>
        a.forgot{
            color: #77829d;
        }

        a.forgot:hover{
            color: #33446d;
        }
        
        a.item.signin{
            color: #fff;
        }

    </style>
@endsection

@section('main-menu')
    @include('partials.auth._top_bar')
@endsection

@section('main')
    <div id="main" class="ui container">
        <div class="ui container center aligned" style="padding-top: 1.5em; padding-bottom: 5em; background: transparent;">
            <h2 class="header"  style="margin-bottom: 1em; color: #33446d;">{{ trans('auth.sign_in') }}</h2>
            <div class="ui two column centered grid">
                <div class="twelve wide computer fifteen wide tablet sixteen wide mobile column">
                    <div class="ui three column middle aligned very relaxed stackable grid">
                        <div class="seven wide column">
                            <div style="margin-left: 1em; margin-right: 1em;">
                                @if(session('error'))
                                    <div class="ui negative tiny compact icon message" style="min-width: 100%;">
                                        <i class="warning icon"></i>
                                        <div class="content">
                                            <div class="header">
                                                {!! trans('auth.error_login_h') !!}
                                            </div>
                                            <p>{!! trans('auth.error_login_p') !!}</p>
                                        </div>
                                    </div>
                                @endif
                                <form class="ui form {{ $errors->any() ? ' error' : '' }}" method="POST" action="{{ route('user.post.login') }}">
                                    {{ csrf_field() }}
                                    <div class="field {{ $errors->has('username') ? 'error' : '' }}">
                                        {{--<label>Username</label>--}}
                                        <div class="ui left icon input">
                                            <input type="text" placeholder="{{ trans('general.phone_number') }} {{ trans('auth.or') }} email" name="username" value="{{ old('username') }}">
                                            <i class="mail icon" style="color: #4a597d;"></i>
                                        </div>
                                    </div>
                                    <div class="field {{ $errors->has('password') ? 'error' : '' }}">
                                        {{--<label>Password</label>--}}
                                        <div class="ui left icon input">
                                            <input type="password" name="password" placeholder="{{ trans('auth.password') }}">
                                            <i class="lock icon" style="color: #4a597d;"></i>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="ui checkbox">
                                            <input type="checkbox" name="remember">
                                            <label style="color: #4a597d;">{{ trans('auth.remember_me') }}</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="ui submit button fluid sigin">{{ trans('auth.sign_in') }}</button>

                                    <div class="ui container center aligned" style="margin-top: 2em;">
                                        <a class="btn btn-link forgot" href="{{ route('user.get.pass.reset') }}">
                                            {{ trans('auth.forgot_password') }}
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="one wide column">
                            <div class="ui vertical divider" style="color: #77829d; text-transform: capitalize; ">
                                {{ trans('auth.or') }}
                            </div>
                        </div>
                        <div class="seven wide center aligned column">
                            <div style="margin-left: 1em; margin-right: 1em;">
                                {{--<div class="ui labeled icon button fluid facebook">--}}
                                    {{--<i class="Facebook F icon"></i>--}}
                                    {{--{{ trans('auth.sign_in_with_face') }}--}}
                                {{--</div>--}}
                                <div class="ui horizontal divider" style="text-transform: capitalize; color: #77829d;">
                                    {{ trans('auth.no_account') }}
                                </div>
                                <a href="{{ route('user.get.register') }}" class="ui button fluid auth action">
                                    {{ trans('auth.register') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
