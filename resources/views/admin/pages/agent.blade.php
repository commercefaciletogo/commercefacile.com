@extends('partials.admin._page')

@section('main')

    <div id="main">

        <div class="ui top attached segment">
            <div class="ui three column grid">
                <div class="six wide column">
                    {{ $agent['name'] }}
                    <!--<div class="mini ui buttons">
                        <button class="ui button">All</button>
                        <button class="ui button">Active</button>
                        <button class="ui button">Inactive</button>
                    </div>-->
                </div>

                <div class="four wide column">
                    <div class="ui mini horizontal statistic">
                        <div class="value">
                            {{ $agent['total_subs'] }}
                        </div>
                        <div class="label">
                            Subscribers
                        </div>
                    </div>
                </div>
                
                <div class="six wide right aligned column">
                    <div class="mini ui buttons">
                        <a href="{{ route('admin.agents') }}" class="ui button"><i class="icon arrow left"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui attached segment">

            <table class="ui very basic table">
                <thead>
                <tr>
                    <th>Phone</th>
                    <th>Date</th>
                    <th>Total Ads</th>
                </tr>
                </thead>
                <tbody>
                @foreach($agent['subscribers'] as $sub)
                    <tr>
                        <td>{{ $sub['phone'] }}</td>
                        <td>{{ $sub['date'] }}</td>
                        <td>{{ $sub['ads'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>

    </div>

@endsection