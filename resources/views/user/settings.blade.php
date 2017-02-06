@extends('partials.master._profile')


@section('styles')
    <style>
        .ui.horizontal.divider:before, .ui.horizontal.divider:after{
            /*background: none;*/
        }
    </style>
@endsection


@section('content')

    <div class="ui container">
        <div class="row">
            <div class="ui centered grid">
                <div class="ui horizontal divider" style="text-transform: none;">
                    <h4>Personal Details</h4>
                </div>
                <div class="eight wide computer ten wide tablet sixteen wide mobile column">
                    <form class="ui form" style="margin-left: 1.5em; margin-right: 1.5em;">
                        <div class="field">
                            <label>Full Name</label>
                            <input type="text" placeholder="Full Name">
                        </div>
                        <div class="field">
                            <label>Email</label>
                            <input type="email" placeholder="Email Address">
                        </div>

                        <div class="field">
                            <label>Location</label>
                            <input type="text" placeholder="Location">
                        </div>

                        <div class="field">
                            <label>Phone Number</label>
                            <input type="text" placeholder="Phone Number">
                        </div>
                        
                        <button class="ui button" type="submit">Update</button>
                    </form>
                </div>
            </div>
                
        </div>

        <div class="row">
            <div class="ui centered grid">
                <div class="ui horizontal divider" style="text-transform: none;">
                    <h4>Change Password</h4>
                </div>
                <div class="eight wide computer ten wide tablet sixteen wide column">
                    <form class="ui form" style="margin-left: 1.5em; margin-right: 1.5em;">
                        <div class="field">
                            <label>Current Password</label>
                            <input type="password" placeholder="*****">
                        </div>
                        <div class="field">
                            <label>New Password</label>
                            <input type="password" placeholder="*****">
                        </div>
                        <div class="field">
                            <label>Confirm Password</label>
                            <input type="password" placeholder="*****">
                        </div>                                        
                        <button class="ui button" type="submit">Change</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection