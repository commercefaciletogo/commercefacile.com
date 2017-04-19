@extends('partials.master._profile')


@section('styles')
    <style>
        .ui.horizontal.divider:before, .ui.horizontal.divider:after{
            /*background: none;*/
        }

         .ui.form .field input, .ui.form textarea, .ui.form input[type="text"], label{
            color: #4a597d !important;
        }

        .ui.form .field input:focus, .ui.form textarea:focus, .ui.form input[type="text"]:focus{
            border-color: #4a597d !important;
            color: #4a597d !important;
        }

        button.ui.fluid.button{
            background: #4a597d !important;
            color: #fff !important;
        }

        div.remodal{
            background: #e8eaee;
            max-width: 400px !important;
        }

        button.remodal-close{
            color: #FB344B;
        }

         div.ui.styled.accordion{
            background: transparent !important;
            box-shadow: none;
            border-radius: 0;
        }
    </style>
@endsection

@section('meta')
    @include('partials.profile._meta', ['user' => auth('user')->user()])
@endsection


@section('content')

    <div class="ui container" v-cloak>
        <div class="row">
            <div class="ui centered grid">
                <div class="ui horizontal divider" style="text-transform: none;">
                    <h4>{{trans('general.personal_details')}}</h4>
                </div>
                <div class="eight wide computer ten wide tablet sixteen wide mobile column">
                    <form @submit.prevent="updateInfo" :class="['ui form', {loading: updatingProfile}]" style="margin-left: 1.5em; margin-right: 1.5em;">
                        <div :class="['field', {error: user.errors.name}]">
                            <label>{{trans('general.full_name')}}</label>
                            <input v-model="user.fullName" type="text">
                        </div>
                        <div :class="['field', {error: user.errors.email}]">
                            <label>Email</label>
                            <input v-model="user.email" type="email">
                        </div>

                        <div class="field">
                            <label>{{trans('general.phone_number')}}</label>
                            <div :class="['ui right labeled fluid small', {error: user.errors.phone}, 'input']">
                                <div class="ui basic label" style="color: #4a597d;">+228</div>
                                <input v-model="user.phoneNumber" style="border-right-color: rgba(34, 36, 38, 0.15) !important;" type="text" >
                            </div>
                        </div>

                        <div class="field">
                            <label>{{trans('general.location')}}</label>
                            <div class="ui right action fluid small input">
                                <input v-model="user.location.text" type="text" readonly>
                                <div data-remodal-target="choose-location" class="ui basic floating button">
                                    <i class="dropdown icon"></i>
                                </div>
                            </div>
                        </div>
                        
                        <button class="ui fluid button" type="submit">{{trans('general.update')}}</button>
                    </form>
                </div>
            </div>
                
        </div>

        <div class="row">
            <div class="ui centered grid">
                <div class="ui horizontal divider" style="text-transform: none;">
                    <h4>{{trans('general.change_password')}}</h4>
                </div>
                <div class="eight wide computer ten wide tablet sixteen wide column">
                    <div class="ui negative tiny compact icon message" v-if="password.error">
                        <i class="warning icon"></i>
                        <div class="content">
                            <div class="header">
                                {!! trans('auth.error_login_h') !!}
                            </div>
                            <p>{!! trans('auth.error_login_p') !!}</p>
                        </div>
                    </div>

                    <div class="ui positive tiny compact message" v-if="password.updated" style="min-width: 100%;">
                        <div class="content">
                            <p>{!! trans('general.success_update_p') !!}</p>
                        </div>
                    </div>

                    <form @submit.prevent="changePassword" :class="['ui form', {loading: updatingPassword}]" style="margin-left: 1.5em; margin-right: 1.5em;">
                        <div class="field">
                            <label>{{trans('auth.current_password')}}</label>
                            <input v-model="password.currentPassword" type="password" placeholder="*****">
                        </div>
                        <div class="field">
                            <label>{{trans('auth.new_password')}}</label>
                            <input v-model="password.newPassword" type="password" placeholder="*****">
                        </div>
                        <div class="field">
                            <label>{{trans('auth.confirm_password')}}</label>
                            <input v-model="password.newPasswordConfirm" type="password" placeholder="*****">
                        </div>                                        
                        <button class="ui fluid button" type="submit">{{trans('general.change')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="remodal" data-remodal-id="choose-location" id="chooseLocation" data-remodal-options="closeOnOutsideClick: false">
            <button data-remodal-action="close" style="" class="remodal-close"></button>
            <div class="ui styled accordion">
                    <option-item @selected="closeLocationModal"  v-for="location in locations" :item="location"></option-item>
            </div>
    </div>

@endsection

@section('scripts')
    <script>
        var loginUser = {!! json_encode($user) !!};
        var updateProfileUrl = "{!! route('user.profile.settings.update.profile', ['user_name' => $user['slug']]) !!}";
        var updatePasswordUrl = "{!! route('user.profile.settings.update.password', ['user_name' => $user['slug']]) !!}";
    </script>
    <script src="https://b86068563707f1548c7c-cc73bb3144250bf95e4a0690bc25f5d2.ssl.cf5.rackcdn.com/assets/user-settings.js"></script>
@endsection