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
                                <form class="ui form" method="POST" action="{{ route('user.post.pass.phone') }}">
                                    {{ csrf_field() }}
                                    <div class="field {!! $errors->has('phone') ? 'error' : '' !!}">
                                        <div class="ui left icon input">
                                            <input type="tel" required placeholder="{!! trans('general.phone_number') !!}" name="phone" value="{{ old('phone') }}">
                                            <i class="phone icon" style="color: #4a597d;"></i>
                                        </div>
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
