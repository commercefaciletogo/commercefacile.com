<div class="row bottom-bar" style="padding: 1em; border-bottom: 2px solid rgb(209, 213, 222);">
    <div class="ui tow column grid" style="">
        <div class="twelve wide computer tablet eight wide mobile column" style="display: flex;">
            <div class="ui mini horizontal statistic">
                <div class="value" style="color: #1d305d !important;">
                    {{ $user->ads->count() }}
                </div>
                <div class="label" style="color: #1d305d !important;">
                    {{ trans('general.ads') }}
                </div>
            </div>
        </div>
        <div class="four wide computer tablet eight wide mobile column">
            <a href="{{ route('user.profile.public', ['user_name' => $user->slug]) }}" class="ui fluid small button">
                {{ trans('general.public_profile') }}
            </a>
        </div>
    </div>
</div>