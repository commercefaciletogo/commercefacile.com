@extends('partials.admin._auth')

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
            {{--<h2 class="header"  style="margin-bottom: 1em; color: #33446d;">{{ trans('auth.sign_in') }}</h2>--}}
            <div class="ui small image" style="margin-bottom: 2em;">
                <img src="{{ asset('img/logos/logo_acro.png') }}" alt="" >
            </div>
            <div class="ui two column centered grid">
                <div class="four wide computer fifteen wide tablet sixteen wide mobile column">

                    <div style="margin-left: 1em; margin-right: 1em;">
                        @if($errors->any())
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
                        <form class="ui form {{ $errors->any() ? ' error' : '' }}" method="POST" action="{{ route('admin.post.login') }}">
                            {{ csrf_field() }}
                            <div class="field {{ $errors->has('email') ? 'error' : '' }}">
                                {{--<label>Username</label>--}}
                                <div class="ui left icon input">
                                    <input type="email" name="email" value="{{ old('email') }}">
                                    <i class="mail icon" style="color: #4a597d;"></i>
                                </div>
                            </div>
                            <div class="field {{ $errors->has('password') ? 'error' : '' }}">
                                {{--<label>Password</label>--}}
                                <div class="ui left icon input">
                                    <input type="password" name="password">
                                    <i class="lock icon" style="color: #4a597d;"></i>
                                </div>
                            </div>
                            {{--<div class="field">--}}
                                {{--<div class="ui checkbox">--}}
                                    {{--<input type="checkbox" name="remember">--}}
                                    {{--<label style="color: #4a597d;">{{ trans('auth.remember_me') }}</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <button type="submit" class="ui submit button fluid sigin">{{ trans('auth.sign_in') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
