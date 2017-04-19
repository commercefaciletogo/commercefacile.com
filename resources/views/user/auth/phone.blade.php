@extends('partials.master._auth')

<!-- Main Content -->
@section('main')
    <div id="main" class="ui container">
        <div class="ui container center aligned" style="padding-top: 1.5em; padding-bottom: 5em; background: transparent;">
            <h2 class="header"  style="margin-bottom: 1em; color: #33446d;">{{ trans('general.phone_number') }}</h2>

            <div class="ui two column centered grid">
                <div class="twelve wide computer fifteen wide tablet sixteen wide mobile column" style="background: #e8eaee;">
                    <div class="ui three column middle aligned very relaxed stackable grid">
                        <div class="seven wide column">
                            <div style="margin-left: 1em; margin-right: 1em;">
                                <form class="ui form {{ $errors->any() ? ' error' : '' }}">
                                    <div class="field">
                                        <div class="ui left icon input">
                                            <input type="tel" placeholder="{{ trans('general.phone_number') }}" name="phone">
                                            <i class="mobile icon" style="color: #4a597d;"></i>
                                        </div>
                                    </div>
                                    <button type="submit" class="ui submit button fluid sigin">{{ trans('auth.send_code') }}</button>

                                </form>
                            </div>
                        </div>
                        <div class="one wide column">
                            {{--<div class="ui vertical divider" style="color: #77829d; text-transform: capitalize; ">--}}
                                {{--{{ trans('auth.or') }}--}}
                            {{--</div>--}}
                        </div>
                        <div class="seven wide center aligned column">
                            <div style="margin-left: 1em; margin-right: 1em;">
                                <form class="ui form {{ $errors->any() ? ' error' : '' }}" method="POST" action="{{ route('user.post.email') }}">
                                    {{ csrf_field() }}
                                    <div class="field">
                                        <div class="ui left icon input">
                                            <input type="text" placeholder="Code" name="code">
                                            <i class="code icon" style="color: #4a597d;"></i>
                                        </div>
                                    </div>
                                    <button type="submit" class="ui submit button fluid sigin">{{ trans('auth.verify') }}</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
