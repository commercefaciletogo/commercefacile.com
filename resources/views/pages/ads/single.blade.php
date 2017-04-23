@extends('partials.master._pages')

@section('styles')
    <style>

        .inline-link{
            color: #33446d !important;
            text-decoration: underline;
        }

        div.active.section{
            font-size: 1.5em !important;
        }

        .prev, .next{
            cursor: pointer;
            color: #33446d !important;
        }
        .slick-prev, .slick-next {
            height: 100%;
            border-radius: 10px;
            /*background: #e8eaee;*/
            transition: all;
        }

        .slick-prev:before, .slick-next:before {
            line-height: 0;
            font-size: 15px;
            color: #1d305d;
        }

        .slick-prev:before {
            content: '←';
        }

        .slick-next:before {
            content: '→';
        }

        .slick-prev:hover, .slick-next:hover {
            height: 100%;
            /*background: rgb(96, 110, 141);*/
            background: #e8eaee;
        }

        .slick-prev:hover .slick-prev:before, .slick-next:hover .slick-next:before{
            color: #ffffff !important;
        }

        .activated{
            color: white !important;
            background-color: #33446d !important;
        }

        .ui.fluid.button{
            color: #33446d;
        }

        #Ad_Images, #Ad_Images div.ad_image {
            width: 31.5rem !important;
            height: 31.5rem !important;
        }

        @media only screen and (max-width: 991px) and (min-width: 768px) {
            #Ad_Images, #Ad_Images div.ad_image {
                width: 25rem !important;
                height: 25rem !important;
            }

            /*#Ad_Images, div.ad_image .ad_image {
                width: 350px !important;
                height: 350px !important;
            }*/
        }

        @media only screen and (max-width: 767px) {
            #Ad_Images, #Ad_Images div.ad_image {
                width: 25rem !important;
                height: 25rem !important;
            }

            .prev, .next{
                display: none !important;
            }

            .ui.relaxed.divided.items img {
                width: 2.5rem !important;
                height: 2.5rem !important;
            }
        }
    </style>
@endsection

@section('main')
    <div class="ui container fluid" id="main" style="height: 100%;">

        @include('partials.pages._top_bar')

        <div class="ui container fluid" style="padding-top: 2em; margin-bottom: 10em; color: #33446d !important;">

            <div class="ui container">

                <div class="ui small breadcrumb" style="padding-left: 1em;">
                    <a href="{{ route('ads.multiple') }}" class="section inline-link">{{ trans('general.all') }}</a>
                    @unless(is_null($ad['category']['parent']))
                        <i class="right chevron icon divider"></i>
                        <a href="{{ qs_url(route('ads.multiple'), ['c' => $ad['category']['parent']['uuid']]) }}" class="section inline-link">{{ $ad['category']['parent']['name'] }}</a>
                    @endunless
                    <i class="right chevron icon divider"></i>
                    <a href="{{ qs_url(route('ads.multiple'), ['c' => $ad['category']['uuid']]) }}" class="section inline-link">{{ $ad['category']['name'] }}</a>
                    <i class="right chevron icon divider"></i>
                    <div class="active section">{{ $ad['title'] }}</div>
                    <div class="divider"> / </div>
                    <div class="section"><strong>Condition</strong>: {{ trans("general.{$ad['condition']}") }}</div>
                </div>

                <div id="addInfo" style="margin-top: 1em;padding: .5em; background-color: #fff; border-bottom: 2px solid #d1d5de;">

                    <div class="ui two column centered grid">
                        <div class="twelve wide computer sixteen wide tablet column">
                            <div class="ui stackable tow column grid">
                                <div class="row">
                                    <div class="ten wide computer column">
                                        <div style="display: flex; flex-direction: row; justify-content: center;">
                                            <a class="prev" style="display: flex; flex-direction: column; justify-content: center;">
                                                @unless(count($ad['images']) == 1)
                                                        <i class="left chevron icon"></i>
                                                @endunless
                                            </a>
                                            <div id="Ad_Images" v-cloak class="siema">
                                                @foreach($ad['images'] as $image)
                                                    <div class="ad_image" style="
                                                        background-image: url({!! $image !!});
                                                        background-position: center;
                                                        background-repeat: no-repeat;
                                                        padding: 0;
                                                        background-size: contain;
                                                        ">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <a class="next" style="display: flex; flex-direction: column; justify-content: center;">
                                                @unless(count($ad['images']) == 1)
                                                    <i class="right chevron icon"></i>
                                                @endunless
                                            </a>
                                        </div>
                                    </div>

                                    <div class="six wide computer tablet only column" style="padding-top: 0;">
                                        <div class="ui divided items" style="color: #33446d; padding-top: 1em;">
                                            <div class="item" style="">
                                                <div class="ui mini image">
                                                    <img src="{{ asset('/img/icons/price_tag_512.png') }}">
                                                </div>
                                                <div class="middle aligned content">
                                                    <span style="font-size: 1.5em; font-weight: bold;">
                                                        {!! $ad['price'] !!} CFA
                                                    </span>
                                                    <span style="font-size: 1em; font-weight: bold;">
                                                        @if($ad['negotiable'])
                                                            : {{ trans('general.negotiable') }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="item" style="">
                                                <div class="ui mini image">
                                                    <img src="{{ asset('/img/icons/user.png') }}">
                                                </div>
                                                <div class="middle aligned content">
                                                    <a href="{{ route('user.profile.public', ['user_name' => $ad['owner']['slug']]) }}" class="inline-link">
                                                        {!! title_case($ad['owner']['name']) !!}
                                                    </a>
                                                </div>
                                            </div>
                                            <div v-cloak class="item" style="">
                                                <div class="ui mini image">
                                                    <img src="{{ asset('/img/icons/electronics.png') }}">
                                                </div>
                                                <div v-if="shown" class="middle aligned content">
                                                    <u>{!! $ad['owner']['phone'] !!}</u>
                                                    <i data-clipboard-text="{{$ad['owner']['phone']}}" class="icon big copy" style="cursor:pointer;"></i>
                                                </div>
                                                <div v-else class="middle aligned content">
                                                    {!! "{$ad['owner']['phone'][0]}xxxxxxx" !!}
                                                    <i @click="showPhone" class="icon big eye" style="cursor:pointer;"></i>
                                                </div>
                                            </div>
                                            <div class="item" style="">
                                                <div class="ui mini image">
                                                    <img src="{{ asset('/img/icons/city.png') }}">
                                                </div>
                                                <div class="middle aligned content">
                                                    <a href="{{ qs_url(route('ads.multiple'), ['l' => $ad['owner']['location']['uuid']]) }}" class="inline-link">
                                                        {!! title_case($ad['owner']['location']['name']) !!}
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="item" style="">
                                                <div class="ui mini image">
                                                    <img src="{{ asset('/img/icons/time_512.png') }}">
                                                </div>
                                                <div class="middle aligned content">
                                                    {{ $ad['date']}}
{{--                                                    {{ \Carbon\Carbon::now()->toFormattedDateString()}}--}}
                                                </div>
                                            </div>
                                            <div class="item">
                                                <button {{ auth('user')->check() ? '' : 'disabled' }}
                                                        :class="['ui fluid button', {activated: ad.favorite}]"
                                                        v-cloak
                                                        @click="favoriteAd"
                                                        style="">
                                                    <i class="star empty icon"></i>
                                                    {{ trans('general.save_as_favorite') }}
                                                </button>
                                            </div>
                                            <div class="item">
                                                <button {{ auth('user')->check() ? '' : 'disabled' }}
                                                        :class="['ui fluid button', {activated: ad.reported}]"
                                                        v-cloak
                                                        @click="reportAd"
                                                        style="">
                                                    <i class="ban icon"></i>
                                                    {{ trans('general.report_ad') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="six wide mobile only center aligned column">
                                        <div>
                                            <div class="ui buttons">
                                                <button class="ui labeled icon button mob-prev"
                                                        style="background: none!important; color: #33446d !important;">
                                                    @unless(count($ad['images']) == 1)
                                                        <i class="left chevron icon"></i>
                                                    @endunless
                                                </button>
                                                <button class="ui right labeled icon button mob-next"
                                                        style="background: none!important; color: #33446d !important;">
                                                    @unless(count($ad['images']) == 1)
                                                        <i class="right chevron icon"></i>
                                                    @endunless
                                                </button>
                                            </div>
                                        </div>
                                        <div class="ui huge pointing label" style="margin-bottom: .4em; background-color: #33446d !important; color: white !important;">
                                            {{ $ad['price'] }} CFA
                                        </div>

                                        <div class="" style="margin-bottom: 1.5em;">
                                            @if($ad['negotiable'])
                                                <span>{{ trans('general.negotiable') }}</span>
                                            @endif
                                        </div>
                                        <p class="ui container center aligned">
                                            <img class="ui mini spaced image" style="width: 1.25rem;"
                                                 src="{{ asset('/img/icons/user.png') }}">
                                            <a href="{{ route('user.profile.public', ['user_name' => $ad['owner']['slug']]) }}" style="color: #33446d !important; text-decoration: underline;">
                                                {{ $ad['owner']['name'] }}
                                            </a>
                                        </p>
                                        <p class="ui container center aligned">
                                            <img class="ui mini spaced image" style="width: 1.25rem;"
                                                 src="{{ asset('/img/icons/electronics.png') }}">
                                            <span v-if="shown">
                                                <u>{{ $ad['owner']['phone'] }}</u>
                                                <i data-clipboard-text="{{$ad['owner']['phone']}}" class="icon big copy" style="cursor:pointer;"></i>
                                            </span>
                                            <span v-else>
                                                {{ "{$ad['owner']['phone'][0]}xxxxxxx" }}
                                                <i @click="showPhone" class="icon big eye" style="cursor:pointer;"></i>
                                            </span>
                                        </p>
                                        <p class="ui container center aligned">
                                            <img class="ui mini spaced image" style="width: 1.25rem;"
                                                 src="{{ asset('/img/icons/time_512.png') }}">
                                            {{ $ad['date'] }}
                                        </p>
                                        <p class="ui container center aligned">
                                            <img class="ui mini spaced image" style="width: 1.25rem;"
                                                 src="{{ asset('/img/icons/city.png') }}">
                                            <a href="{{ qs_url(route('ads.multiple'), ['l' => $ad['owner']['location']['uuid']]) }}" style="color: #33446d !important; text-decoration: underline;">
                                                {{ $ad['owner']['location']['name'] }}
                                            </a>
                                        </p>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="ui grid" style="">

                    <div class="row">
                        <div class="column">
                            <div style="margin-top: 1em;padding: .5em; background-color: #fff; border-bottom: 2px solid #d1d5de;">
                                <div class="ui stackable tow column grid">
                                    <div class="eight wide column">
                                        <h4 class="ui horizontal divider header" style="color: #33446d !important;">
                                            Description
                                        </h4>
                                        <p class="ui container left aligned">
                                            {{ $ad['description'] }}
                                        </p>
                                    </div>
                                    <div class="eight wide column">
                                        {{--<p class="ui container center aligned">--}}
                                            {{--Condition: {{ $ad['condition'] }}--}}
                                        {{--</p>--}}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mobile only row">
                        <div class="column">
                            <div style="margin-top: 1em;padding: .5em; background-color: #fff; border-bottom: 2px solid #d1d5de;">
                                <button
                                        {{ auth('user')->check() ? '' : 'disabled' }}
                                        v-cloak
                                        @click="favoriteAd"
                                        style="margin-bottom: 1em;"
                                        :class="['ui fluid button', {active: ad.favorite}]">
                                    <i class="star empty icon"></i>
                                    {{ trans('general.save_as_favorite') }}
                                </button>
                                <button
                                        {{ auth('user')->check() ? '' : 'disabled' }}
                                        v-cloak
                                        @click="reportAd"
                                        :class="['ui fluid button', {active: ad.reported}]"
                                        style=""
                                        >
                                    <i class="ban icon"></i>
                                    {{ trans('general.report_ad') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @if(collect($similar_ads)->isNotEmpty())
                            <div class="sixteen wide computer tablet sixteen wide mobile column">
                                <div style="margin-top: 1em;padding: .5em; background-color: #fff; border-bottom: 2px solid #d1d5de;">
                                    <h4 class="ui horizontal divider header" style="color: #33446d !important;">
                                        {{ trans('general.similar_ads') }}
                                    </h4>
                                    <div class="row" style="background: transparent;">
                                        <div class="ads-slide" v-cloak style="height: 100px;">
                                            @foreach($similar_ads as $ad)
                                                <a href="{{ route('ads.single', ['id' => $ad['uuid']]) }}" style="width: 322px; color: #1d305d; margin-right: .5em;">
                                                    <div class="ui container" style="background-color: #fcfcfd;">
                                                        <div class="ui grid" style="margin: 0;">
                                                            <div class="column" style="
                                                                    background-image: url({!! $ad['image'] !!});
                                                                    background-position: center;
                                                                    background-repeat: no-repeat;
                                                                    padding: 0;
                                                                    width: 100px;
                                                                    height: 100px;
                                                                    background-size: contain;
                                                                    ">
                                                            </div>
                                                            <div class="column"
                                                                 style="width: 222px!important;display: flex;flex-direction: column;justify-content: space-between;">
                                                                <div class="row title" style="font-size: 1.5em;">
                                                                    <span>{{ $ad['title'] }}</span>
                                                                </div>
                                                                <div class="row description" style="color: #77829d;">
                                                                    <span>{{ $ad['description'] }}</span>
                                                                </div>
                                                                <div class="row price" style="font-size: 1.2em;">
                                                                    {{ $ad['price'] }} FCFA
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var favoriteAdUrl = "{!! route('ads.single.favorite', ['id' => $ad['uuid']]) !!}";
        var unfavoriteAdUrl = "{!! route('ads.single.unfavorite', ['id' => $ad['uuid']]) !!}";
        var reportAdUrl = "{!! route('ads.single.report', ['id' => $ad['uuid']]) !!}";
        var dereportAdUrl = "{!! route('ads.single.dereport', ['id' => $ad['uuid']]) !!}";
        var ad = {!! json_encode($ad) !!};
    </script>
    <script src="https://b86068563707f1548c7c-cc73bb3144250bf95e4a0690bc25f5d2.ssl.cf5.rackcdn.com/assets/single.js"></script>
@endsection
