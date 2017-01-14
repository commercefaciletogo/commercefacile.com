@extends('partials.master._auth')

@section('main')

    <div class="ui container center aligned" style="margin-top: 5em; margin-bottom: 5em;">

        <h2 class="header"  style="margin-bottom: 2em; color: #33446d;">Register</h2>

        <div class="ui two column centered grid">
            <div class="column" style="background: #e8eaee;">
                <div class="ui two column aligned very relaxed stackable grid">
                    <div class="column">
                        <div class="ui labeled icon button fluid facebook">
                            <i class="Facebook F icon"></i>
                            Register with Facebook
                        </div>

                        <div class="ui horizontal divider" style="color: #77829d; text-transform: capitalize; ">
                            Or
                        </div>

                        <form class="ui form {{ $errors->any() ? ' error' : '' }}" method="POST" action="{{ route('user.post.email') }}">
                            {{ csrf_field() }}
                            <div class="field">
                                <div class="ui left icon input">
                                    <input type="text" placeholder="Full Name" name="name" value="{{ old('name') }}">
                                    <i class="user icon" style="color: #4a597d;"></i>
                                </div>
                                @if ($errors->has('name'))
                                    <div class="ui error message">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </div>
                                @endif
                            </div>
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
                            <div class="field">
                                <div class="ui left icon input">
                                    <input type="password" name="password" placeholder="Password">
                                    <i class="lock icon" style="color: #4a597d;"></i>
                                </div>
                                @if ($errors->has('password'))
                                    <div class="ui error message">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="field">
                                <div class="ui left icon input">
                                    <input type="password" name="password_confirmation" placeholder="Confirm Password">
                                    <i class="checkmark icon" style="color: #4a597d;"></i>
                                </div>
                                @if ($errors->has('password_confirmation'))
                                    <div class="ui error message">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <button type="submit" class="ui submit button fluid">Register</button>

                        </form>

                        <div class="ui horizontal divider" style="text-transform: capitalize; color: #77829d;">
                            Already A Member?
                        </div>
                        <a href="{{ route('user.get.login') }}" class="ui button fluid auth action">
                            Sign In
                        </a>
                    </div>
                    <div class="ui vertical divider" style="color: #77829d; text-transform: capitalize; ">
                        Why?
                    </div>
                    <div class="column">
                        <h3 class="header" style="margin-top: 1em; color: #33446d;">New to commercefacile?</h3>
                        <h5 class="header" style="margin-top: 1em; color: #33446d;"><i>Creating an account lets you:</i></h5>
                        <div class="ui list" style="color: #33446d; font-size: 1.1em;">
                            <div class="item" style="margin-top: 2em;">
                                <i class="users icon"></i>
                                <div class="content">
                                    Post your own ads.
                                </div>
                            </div>
                            <div class="item" style="margin-top: 2em;">
                                <i class="users icon"></i>
                                <div class="content">
                                    Mark ads as favorite and view them later.
                                </div>
                            </div>
                            <div class="item" style="margin-top: 2em;">
                                <i class="marker icon"></i>
                                <div class="content">
                                    View and manage your existing ads.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
