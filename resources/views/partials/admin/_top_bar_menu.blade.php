<div class="ui small borderless menu" id="topMenu">
    <a class="item {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}"
        href="{{ route('admin.dashboard') }}">
        Dashboard
    </a>
    <div class="right menu">
        <a class="item {{ starts_with(Route::currentRouteName(), 'admin.ad') ? 'active' : '' }}"
            href="{{ route('admin.ads') }}">
            Ads
            <div v-cloak v-show="pending" style="top: 0 !important;" class="floating ui red empty circular label"></div>
        </a>
        <a class="item {{ Route::currentRouteName() == 'admin.employees' ? 'active' : '' }}"
            href="{{ route('admin.employees') }}">
            Employees
        </a>
        <a class="item {{ Route::currentRouteName() == 'admin.users' ? 'active' : '' }}"
           href="{{ route('admin.users') }}">
            Users
        </a>
    </div>

    <div class="right menu">
        <div class="item">
            <div class="ui search">
                <div class="ui left icon input">
                    <input class="prompt" type="text" placeholder="Search ...">
                    <i class="search icon"></i>
                </div>
            </div>
        </div>
        <div class="ui simple dropdown item">
            {{ trans('general.languages') }} <i class="dropdown icon"></i>
            <div class="menu">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <a class="item {{ LaravelLocalization::getCurrentLocale() == $localeCode ? 'active' : ''  }}" rel="alternate" hreflang="{{$localeCode}}" href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
                        {{ $properties['native'] }}
                    </a>
                @endforeach
            </div>
        </div>
        <div class="ui simple dropdown item">
            Thomas Dola <i class="dropdown icon"></i>
            <div class="menu">
                <a class="item" data-remodal-target="change-password">
                    Change Password
                </a>
                <a class="item" href="">
                    Sign Out
                </a>
            </div>
        </div>
    </div>

    <div style="width: 350px !important;" class="remodal" data-remodal-id="change-password" id="changePassword" data-remodal-options="closeOnOutsideClick: false">
        <button v-if="!changing" data-remodal-action="close" class="remodal-close"></button>
        <div class="ui container left aligned">
            <form @submit.prevent="changePassword" :class="['ui form ', {loading:changing}]" style="margin-left: 1.5em; margin-right: 1.5em;">
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