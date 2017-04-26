@extends('partials.admin._page')

@section('main')

    <div id="main">

        <div class="ui top attached segment">
            <div class="ui three column grid">
                <div class="four wide column">
                    <div class="ui mini horizontal statistic">
                        <div class="value">
                            {{--56--}}
                        </div>
                        <div class="label">
                            Employees
                        </div>
                    </div>
                </div>
                <div class="six wide column">
                    <div class="mini ui buttons">
                        <button class="ui button">All</button>
                        <button class="ui button">Active</button>
                        <button class="ui button">Inactive</button>
                    </div>
                </div>
                <div class="six wide right aligned column">
                    <div class="mini ui buttons">
                        <button data-remodal-target="new-employee" class="ui button">+</button>
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
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($employees as $employee)
                    <tr>
                        <td>{{ $employee['name'] }}</td>
                        <td>{{ $employee['email'] }}</td>
                        <td>{{ ucfirst($employee->role->name) }}</td>
                        {{--<td>--}}
                            {{--<div class="ui mini compact {{ $employee['status'] == 'active' ? 'green' : 'red' }} horizontal label">--}}
                                {{--{{ $employee['status'] }}--}}
                            {{--</div>--}}
                        {{--</td>--}}
                        <td>
                            <form action="{{ route('employee.delete') }}" class="ui form" method="POST" style="margin-bottom: 0 !important;">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="id" value="{{ $employee['id'] }}">
                                <button type="submit" class="mini compact ui button">
                                    delete
                                </button>
                            </form>
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

    <div style="width: 350px !important;" class="remodal" data-remodal-id="new-employee" id="newEmployee" data-remodal-options="closeOnOutsideClick: false">
        <button data-remodal-action="close" class="remodal-close"></button>
        <div class="ui container left aligned">
            <form class="ui form" style="margin-left: 1.5em; margin-right: 1.5em;" method="post" action="{{ route('employee.save') }}">
                {{ csrf_field() }}
                <div class="field">
                    <label>Name</label>
                    <input type="text" name="name" placeholder="name">
                </div>
                <div class="field">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="email">
                </div>
                <div class="field">
                    <label>Role</label>
                    <select name="role" id="role">
                        @foreach($roles as $role)
                            <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="ui fluid button" type="submit">add</button>
            </form>
        </div>
    </div>

@endsection