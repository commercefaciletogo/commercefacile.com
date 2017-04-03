@extends('partials.admin._page')

@section('main')

    <div id="main">

        <div class="ui top attached segment">
            <div class="ui three column grid">
                <div class="four wide column">
                    <div class="ui mini horizontal statistic">
                        <div class="value">
                            56
                        </div>
                        <div class="label">
                            Employees
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
                    <th>Username</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>45dsf465f</td>
                    <td>Thomas Dola</td>
                    <td>thomas.Dola89</td>
                    <td>thomasdolar@gmail.com</td>
                    <td>
                        <div class="ui mini compact green horizontal label">active</div>
                    </td>
                    <td>
                        <button class="mini compact ui button">
                            deactivate
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>45dsf465f</td>
                    <td>Thomas Dola</td>
                    <td>Thomas.Dola</td>
                    <td>ThomasDola@fja.com</td>
                    <td>
                        <div class="ui mini compact red horizontal label">inactive</div>
                    </td>
                    <td>
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

@endsection