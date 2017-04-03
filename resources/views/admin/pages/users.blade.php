@extends('partials.admin._page')

@section('main')

    <div id="main">

        <div class="ui top attached segment">
            <div class="ui three column grid">
                <div class="four wide column">
                    <div class="ui mini horizontal statistic">
                        <div class="value">
                            2,204,456
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
                        <button class="ui button">All</button>
                        <button class="ui button">Active</button>
                        <button class="ui button">Inactive</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui attached segment">

            <table class="ui very basic table">
                <thead>
                <tr>
                    <th>#Code</th>
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
                <tr>
                    <td>45dsf465f</td>
                    <td>Thomas Dola</td>
                    <td>Amoutivie</td>
                    <td>90110735</td>
                    <td>thomasdolar@mgail.com</td>
                    <td>20</td>
                    <td>12/12/12</td>
                    <td>
                        <div class="ui mini compact green horizontal label">active</div>
                    </td>
                    <td>
                        <button class="mini compact ui button">
                            profile
                        </button>
                        <button class="mini compact ui button">
                            deactivate
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>45dsf465f</td>
                    <td>Thomas Dola</td>
                    <td>Amoutivie</td>
                    <td>90110735</td>
                    <td>thomasdolar@mgail.com</td>
                    <td>20</td>
                    <td>12/12/12</td>
                    <td>
                        <div class="ui mini compact red horizontal label">inactive</div>
                    </td>
                    <td>
                        <button class="mini compact ui button">
                            profile
                        </button>
                        <button class="mini compact ui button">
                            activate
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
        <div class="ui bottom attached segment">
            <p>This segment is on bottom</p>
        </div>

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