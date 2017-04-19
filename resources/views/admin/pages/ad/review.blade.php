@extends('partials.admin._page')

@section('main')

    <div id="main">

        <div class="ui segment" style="margin-bottom: .5em;">
            <div class="ui grid">
                <div class="eight wide column">
                    <h4 class="ui header">Ad #{{ $ad['code'] }}</h4>
                </div>
                <div class="eight wide right aligned column">
                    <div class="ui grid">
                        <div class="eight wide column">
                            <a href="{{ route('admin.ads') }}" class="ui tiny compact button">{{ trans('general.back') }}</a>
                        </div>
                        <div class="eight wide column">
                            <button v-cloak @click="commit" :class="['ui tiny', {disabled:disabled}, 'compact button']">{{ trans('general.commit') }}</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="ui stackable column grid">
            <div class="eight wide column">
                <div v-cloak :class="['ui ', review.title === null ? 'gray' : review.title === true ? 'green' : 'red' ,' top attached segment']">
                    <div class="ui grid">
                        <div class="eight wide column">
                            <h4 class="ui header">{{ trans('general.ad_title') }}</h4>
                        </div>
                        <div class="eight wide right aligned column">
                            <div class="ui mini buttons">
                                <button @click="toggle('title', true)" class="ui button">{{ trans('general.accept') }}</button>
                                <div class="or"></div>
                                <button @click="toggle('title', false)" class="ui button">{{ trans('general.reject') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ui bottom attached segment">
                    <p>{{ $ad['title'] }}</p>
                </div>

                <div v-cloak :class="['ui ', review.category === null ? 'gray' : review.category === true ? 'green' : 'red' ,' top attached segment']">
                    <div class="ui grid">
                        <div class="eight wide column">
                            <h4 class="ui header">{{ trans('general.ad_category') }}</h4>
                        </div>
                        <div class="eight wide right aligned column">
                            <div class="ui mini buttons">
                                <button @click="toggle('category', true)" class="ui button">{{ trans('general.accept') }}</button>
                                <div class="or"></div>
                                <button @click="toggle('category', false)" class="ui button">{{ trans('general.reject') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ui bottom attached segment">
                    <div class="ui breadcrumb">
                        @if($ad['category']['parent'])
                            <div class="section">{{ $ad['category']['parent']['name'] }}</div>
                            <i class="right angle icon divider"></i>
                        @endif
                        <div class="section">{{ $ad['category']['name'] }}</div>
                    </div>
                </div>

                <div v-cloak :class="['ui ', review.condition === null ? 'gray' : review.condition === true ? 'green' : 'red' ,' top attached segment']">
                    <div class="ui grid">
                        <div class="eight wide column">
                            <h4 class="ui header">{{ trans('general.condition') }}</h4>
                        </div>
                        <div class="eight wide right aligned column">
                            <div class="ui mini buttons">
                                <button @click="toggle('condition', true)" class="ui button">{{ trans('general.accept') }}</button>
                                <div class="or"></div>
                                <button @click="toggle('condition', false)" class="ui button">{{ trans('general.reject') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ui bottom attached segment">
                    <p>{{ $ad['condition'] }}</p>
                </div>

                <div v-cloak :class="['ui ', review.description === null ? 'gray' : review.description === true ? 'green' : 'red' ,' top attached segment']">
                    <div class="ui grid">
                        <div class="eight wide column">
                            <h4 class="ui header">{{ trans('general.ad_description') }}</h4>
                        </div>
                        <div class="eight wide right aligned column">
                            <div class="ui mini buttons">
                                <button @click="toggle('description', true)" class="ui button">{{ trans('general.accept') }}</button>
                                <div class="or"></div>
                                <button @click="toggle('description', false)" class="ui button">{{ trans('general.reject') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ui bottom attached segment">
                    <p>{{ $ad['description'] }}</p>
                </div>

                <div v-cloak :class="['ui ', review.price === null ? 'gray' : review.price === true ? 'green' : 'red' ,' top attached segment']">
                    <div class="ui grid">
                        <div class="eight wide column">
                            <h4 class="ui header">{{ trans('general.ad_price') }}</h4>
                        </div>
                        <div class="eight wide right aligned column">
                            <div class="ui mini buttons">
                                <button @click="toggle('price', true)" class="ui button">{{ trans('general.accept') }}</button>
                                <div class="or"></div>
                                <button @click="toggle('price', false)" class="ui button">{{ trans('general.reject') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-cloak class="ui bottom attached segment">
                    <div class="ui grid">
                        <div class="eight wide column">
                            <p>{{ $ad['price'] }} FCFA</p>
                        </div>
                        <div class="eight wide column">
                            <div class="ui {{ $ad['negotiable'] ?: "checked" }} checkbox">
                                <input type="checkbox" disabled checked="">
                                <label>{{ trans('general.negotiable') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="eight wide column">
                <div v-cloak :class="['ui ', review.images === null ? 'gray' : review.images === true ? 'green' : 'red' ,' top attached segment']">
                    <div class="ui grid">
                        <div class="eight wide column">
                            <h4 class="ui header">{{ trans('general.ad_images') }}</h4>
                        </div>
                        <div class="eight wide right aligned column">
                            <div class="ui mini buttons">
                                <button @click="toggle('images', true)" class="ui button">{{ trans('general.accept') }}</button>
                                <div class="or"></div>
                                <button @click="toggle('images', false)" class="ui button">{{ trans('general.reject') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <h5 class="ui attached header">
                    {{ trans('general.small') }}
                </h5>
                <div class="ui attached segment">
                    <div class="ui tiny images">
                        @foreach($ad['images']['small'] as $image)
                            <img class="ui image" src="{{ $image['path'] }}">
                        @endforeach
                    </div>
                </div>

                <h5 class="ui attached header">
                    {{ trans('general.big') }}
                </h5>
                <div class="ui attached segment">
                    <div class="ui big images">
                        @foreach($ad['images']['big'] as $image)
                            <img class="ui image" src="{{ $image['path'] }}">
                        @endforeach
                    </div>
                </div>
                <h5 class="ui attached header">
                    {{ trans('general.original') }}
                </h5>
                <div class="ui bottom attached segment">
                    <div class="ui big images">
                        @foreach($ad['images']['original'] as $image)
                            <img class="ui image" src="{{ $image['path'] }}">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    <script>
        var reviewAdApiUrl = "{!! LaravelLocalization::getLocalizedURL(null, route('api.ad.review', ['id' => $ad['id']])) !!}";
        var adsUrl = "{!! LaravelLocalization::getLocalizedURL(null, route('admin.ads')) !!}";
    </script>
    @if(App::environment('production'))
        <script src="https://b86068563707f1548c7c-cc73bb3144250bf95e4a0690bc25f5d2.ssl.cf5.rackcdn.com/assets/admin-page-review-ad.js"></script>
    @else
        <script src="{{ asset('js/admin-page-review-ad.js') }}"></script>
    @endif
@endsection