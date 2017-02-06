<div class="ui vertical footer segment" style="background: white; border-top: solid 5px #33446d; border-bottom: 0;">
    <div class="ui center aligned container">
        <div class="ui stackable divided grid">
            <div class="three wide column">
                <h4 class="ui header">{{ trans('general.how_to_sell_fast') }}</h4>
                <div class="ui link list">
                    <a href="#" class="item">Link One</a>
                    <a href="#" class="item">Link Two</a>
                    <a href="#" class="item">Link Three</a>
                    <a href="#" class="item">Link Four</a>
                </div>
            </div>
            <div class="three wide column">
                <h4 class="ui header">{{ trans('general.help_and_support') }}</h4>
                <div class="ui link list">
                    <a href="#" class="item">Link One</a>
                    <a href="#" class="item">Link Two</a>
                    <a href="#" class="item">Link Three</a>
                    <a href="#" class="item">Link Four</a>
                </div>
            </div>
            <div class="three wide column">
                <h4 class="ui header">{{ trans('general.social') }}</h4>
                <div class="ui link list">
                    <a href="#" class="item">Link One</a>
                    <a href="#" class="item">Link Two</a>
                    <a href="#" class="item">Link Three</a>
                    <a href="#" class="item">Link Four</a>
                </div>
            </div>
            <div class="three wide column">
                <h4 class="ui header">{{ trans('general.about_us') }}</h4>
                <div class="ui link list">
                    <a href="#" class="item">Link One</a>
                    <a href="#" class="item">Link Two</a>
                    <a href="#" class="item">Link Three</a>
                    <a href="#" class="item">Link Four</a>
                </div>
            </div>
            <div class="four wide column">
                <h4 class="ui header">{{ trans('general.languages') }}</h4>
                <div class="ui link list">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a class="item" rel="alternate" hreflang="{{$localeCode}}" href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
                            {{ $properties['native'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="ui section divider"></div>
        <img src="/img/logo-acro.png" class="ui centered mini image">
        <div class="ui horizontal " style="color: #a4acbe;">
            Copyright &COPY; Commercefacile SARL, {{ trans('general.all_right_reserved') }}
        </div>
    </div>
</div>