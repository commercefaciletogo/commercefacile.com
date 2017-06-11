@extends('partials.admin._page')

@section('main')

    <div id="main">

        <div class="ui top attached segment">
            <div class="ui three column grid">
                <div class="four wide column">
                    <div class="ui mini horizontal statistic">
                        <!--<div class="value">
                        </div>-->
                        <div class="label">
                            Agents
                        </div>
                    </div>
                </div>
                <div class="six wide column">
                    <!--<div class="mini ui buttons">
                        <button class="ui button">All</button>
                        <button class="ui button">Active</button>
                        <button class="ui button">Inactive</button>
                    </div>-->
                </div>
                <div class="six wide right aligned column">
                    <div class="mini ui buttons">
                        <button data-remodal-target="new-agent" class="ui button">+</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui attached segment">

            <table class="ui very basic table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Link</th>
                    <th>Subcribers</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($agents as $agent)
                    <tr>
                        <td>{{ $agent['name'] }}</td>
                        <td>{{ $agent['email'] }}</td>
                        <td>{{ $agent['link'] }}</td>
                        <td>{{ $agent['subscribers'] }}</td>
                        <td>
                            <a href="{{ route('admin.agent', ['id' => $agent['token']]) }}" class="mini compact ui button">
                                details
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>

    </div>

    <div style="width: 350px !important;" class="remodal" data-remodal-id="new-agent" id="newAgent" data-remodal-options="closeOnOutsideClick: false">
        <button data-remodal-action="close" class="remodal-close"></button>
        <div class="ui container left aligned">
            <form class="ui form" style="margin-left: 1.5em; margin-right: 1.5em;" method="post" action="{{ route('admin.agent.save') }}">
                {{ csrf_field() }}
                <div class="field">
                    <label>Name</label>
                    <input type="text" required name="name" placeholder="name">
                </div>
                <div class="field">
                    <label>Email</label>
                    <input type="email" required name="email" placeholder="email">
                </div>
                <button class="ui fluid button" type="submit">add</button>
            </form>
        </div>
    </div>

@endsection