@extends('partials.master._auth')

<!-- Main Content -->
@section('main')
    <div id="main" class="ui container">
        <div class="ui container center aligned" style="padding-top: 1.5em; padding-bottom: 5em; background: transparent;">
            <h2 class="header"  style="margin-bottom: 1em; color: #33446d;">{{ trans('auth.reset_pass') }}</h2>

            <div class="ui two column centered grid">
                <div class="twelve wide computer fifteen wide tablet sixteen wide mobile column" style="background: #e8eaee;">
                    <div class="ui three column middle aligned very relaxed stackable grid">
                        <div class="seven wide column">
                            <div style="margin-left: 1em; margin-right: 1em;">
                                @if(session('error'))
                                <div class="ui negative tiny compact icon message" style="min-width: 100%;">
                                    <i class="warning icon"></i>
                                    <div class="content">
                                        <p>{!! session('error') !!}</p>
                                    </div>
                                </div>
                                @endif
                                <form class="ui form" method="POST" action="{{ route('user.post.pass.phone') }}">
                                    {{ csrf_field() }}
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
                                    <button type="submit" class="ui submit button fluid sigin">{{ trans('auth.send_code') }}</button>

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
                                <a href="{{ route('user.get.register') }}" class="ui button fluid signup">
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
