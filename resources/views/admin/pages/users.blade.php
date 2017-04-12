@extends('partials.admin._page')

@section('main')

    <div id="main">

        <div class="ui top attached segment">
            <div class="ui three column grid">
                <div class="four wide column">
                    <div class="ui mini horizontal statistic">
                        <div class="value">
                            {{ count($users) }}
                        </div>
                        <div class="label">
                            Users
                        </div>
                    </div>
                </div>
                <div class="six wide column">
                    {{--<div class="ui mini fluid icon input">--}}
                    {{--<input type="text" placeholder="Search...">--}}
                    {{--<i class="circular search link icon"></i>--}}
                    {{--</div>--}}
                </div>
                <div class="six wide right aligned column">
                    <div class="mini ui buttons">
                        <button class="ui active button">All</button>
                        {{--<button class="ui button">Active</button>--}}
                        {{--<button class="ui button">Inactive</button>--}}
                    </div>
                </div>
            </div>
        </div>
        <div class="ui attached segment">

            <table class="ui very basic table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Total Ads</th>
                    <th>Registration Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $user['location'] }}</td>
                        <td>{{ $user['phone'] }}</td>
                        <td>{{ $user['email'] }}</td>
                        <td>{{ $user['total_ads'] }}</td>
                        <td>{{ $user['date'] }}</td>
                        <td>
                            <div class="ui mini compact {{ $user['status'] == 'active' ? 'green' : 'red' }} horizontal label">{{ $user['status'] }}</div>
                        </td>
                        <td>
                            <a href="{{ route('user.profile.public', ['username' => $user['slug'] ]) }}" class="mini compact ui button">
                                profile
                            </a>
                            @if(auth('admin')->user()->id == 1)
                                <button class="mini compact ui button">
                                    {{ $user['status'] == 'active' ? 'deactivate' : 'activate' }}
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
        {{--<div class="ui bottom attached segment">--}}
            {{--<p>This segment is on bottom</p>--}}
        {{--</div>--}}

    </div>

    <div style="width: 300px !important; padding: 2em .1em .1em .1em;" class="remodal" data-remodal-id="view-user" id="viewUser" data-remodal-options="closeOnOutsideClick: false">
        <button data-remodal-action="close" class="remodal-close"></button>
        <div class="ui card" style="box-shadow: none !important; border-radius: 0 !important; border-top: 1px solid black;">

            <div class="content">
                <img class="ui avatar image" src="{{ asset('img/icons/user.png') }}"> Thomas Dola
            </div>

            <div class="content">
                <img class="ui avatar image" src="{{ asset('img/icons/city.png') }}"> Be
            </div>

            <div class="content">
                <img class="ui avatar image" src="{{ asset('img/icons/electronics.png') }}"> 90110735
            </div>

            <div class="content">
                <img class="ui avatar image" src="{{ asset('img/icons/mana.png') }}"> Thomas Dola
            </div>

            <div class="extra content">
                <a>

                    2 {{ trans('general.ads') }}
                </a>
            </div>

        </div>
    </div>

@endsection