<div class="ui vertical footer segment" style="background: white; border-top: solid 5px #33446d; border-bottom: 0;">
    <div class="ui center aligned container">
        <div class="ui stackable divided grid">
            <div class="three wide column">
                <h4 class="ui header">{{ trans('general.how_to_sell_fast') }}</h4>
                <div class="ui link list">
                    <a href="{{ route('pages.misc.sell') }}" class="item">{{ trans('general.how_to_sell_fast') }}</a>
                </div>
            </div>
            <div class="three wide column">
                <h4 class="ui header">{{ trans('general.help_and_support') }}</h4>
                <div class="ui link list">
                    <a href="{{ route('pages.misc.faq') }}" class="item">{{ trans('general.faq') }}</a>
                    <a href="{{ route('pages.misc.safe') }}" class="item">{{ trans('general.stay_safe') }}</a>
                    <a href="{{ route('pages.misc.contact') }}" class="item">{{ trans('general.contact_us') }}</a>
                </div>
            </div>
            <div class="three wide column">
                <h4 class="ui header">{{ trans('general.social') }}</h4>
                <div class="ui link list">
                    <a href="https://medium.com/commercefacile" target="_blank" class="item">Blog</a>
                    <a href="https://www.facebook.com/Commercefacilecom-415355405469713/" target="_blank" class="item">Facebook</a>
                    <a href="https://twitter.com/commercefacile" target="_blank" class="item">Twitter</a>
                    <a href="https://www.instagram.com/commercefacile_togo/" target="_blank" class="item">Instagram</a>
                </div>
            </div>
            <div class="three wide column">
                <h4 class="ui header">{{ trans('general.about_us') }}</h4>
                <div class="ui link list">
                    <a href="{{ route('pages.misc.about') }}" class="item">{{ trans('general.about_us') }}</a>
                    <a href="{{ route('pages.misc.terms') }}" class="item">{{ trans('general.term_and_condition') }}</a>
                    <a href="{{ route('pages.misc.privacy') }}" class="item">{{ trans('general.privacy_policy') }}</a>
                </div>
            </div>
            <div class="four wide column">
                <h4 class="ui header">{{ trans('general.languages') }}</h4>
                <div class="ui link list">
                    @foreach(Localization::getSupportedLocales() as $key => $locale)
                        <a class="item {{ localization()->getCurrentLocale() == $key ? 'active' : '' }}" rel="alternate" hreflang="{{ $key }}"
                           href="{{ localization()->getLocalizedURL($key) }}">
                            {{ $locale->native() }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="ui section divider"></div>
        <img src="{!! asset('/img/logos/logo_acro.png') !!}" class="ui centered mini image">
        <div class="ui horizontal " style="color: #a4acbe;">
            Copyright &COPY; Commercefacile SARL, {{ trans('general.all_right_reserved') }}
        </div>
    </div>
</div>
