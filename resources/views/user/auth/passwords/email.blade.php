@extends('partials.master._auth')

<!-- Main Content -->
@section('main')
    <div id="main" class="ui container">
        <div class="ui container center aligned" style="padding-top: 1.5em; padding-bottom: 5em; background: transparent;">
            <h2 class="header"  style="margin-bottom: 1em; color: #33446d;">Reset Password</h2>

            <div class="ui two column centered grid">
                <div class="twelve wide computer fifteen wide tablet sixteen wide mobile column" style="background: #e8eaee;">
                    <div class="ui three column middle aligned very relaxed stackable grid">
                        <div class="seven wide column">
                            <div style="margin-left: 1em; margin-right: 1em;">
                                <form class="ui form {{ $errors->any() ? ' error' : '' }}" method="POST" action="{{ route('user.post.email') }}">
                                    {{ csrf_field() }}
                                    <div class="field">
                                        <div class="ui left icon input">
                                            <input type="text" placeholder="Email" name="email" value="{{ old('email') }}">
                                            <i class="mail icon" style="color: #4a597d;"></i>
                                        </div>
                                        @if ($errors->has('email'))
                                            <div class="ui error message">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="submit" class="ui submit button fluid sigin">Send Password Reset Link</button>

                                </form>
                            </div>
                        </div>
                        <div class="one wide column">
                            <div class="ui vertical divider" style="color: #77829d; text-transform: capitalize; ">
                                Or
                            </div>
                        </div>
                        <div class="seven wide center aligned column">
                            <div style="margin-left: 1em; margin-right: 1em;">
                                <div class="ui labeled icon button fluid facebook">
                                    <i class="Facebook F icon"></i>
                                    Sign in with Facebook
                                </div>
                                <div class="ui horizontal divider" style="text-transform: capitalize; color: #77829d;">
                                    Do Not Have Account Yet?
                                </div>
                                <a href="{{ route('user.get.register') }}" class="ui button fluid signup">
                                    Sign Up
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
