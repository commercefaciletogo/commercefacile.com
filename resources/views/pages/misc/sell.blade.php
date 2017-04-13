@extends('partials.master._auth')

@section('main')
    <div id="main" style="margin-bottom: 5em;">

        <div class="ui container" style="background: #fff; padding-bottom: 5em; border-bottom: 4px solid #d1d5de; margin-top: 2em;">

            <div class="ui two column centered grid">
                <div class="column center aligned">
                    <div class="ui huge header" style="color: #4a597d;">{{ trans('sell.header') }}</div>
                </div>
                <div class="column stackable row" style="padding: 0 1em 0 2em;">
                    <div class="column">
                        <h4 class="ui header">
                            <img class="ui image" src="{{ asset('/img/icons/manage_ads_512.png') }}">
                            <div class="content">
                                {{ trans('sell.price') }}
                            </div>
                        </h4>
                        <ul class="ui list">
                            <li>{{ trans('sell.price_info_one') }}</li>
                            <li>{{ trans('sell.price_info_two') }}</li>
                        </ul>
                    </div>

                    <div class="column">
                        <h4 class="ui header">
                            <img class="ui image" src="{{ asset('/img/icons/manage_ads_512.png') }}">
                            <div class="content">
                                {{ trans('sell.photos') }}
                            </div>
                        </h4>
                        <ul class="ui list">
                            <li>{{ trans('sell.photos_info_one') }}</li>
                            <li>{{ trans('sell.photos_info_two') }}</li>
                            <li>{{ trans('sell.photos_info_three') }}</li>
                        </ul>
                    </div>
                </div>
                <div class="column stackable row" style="padding: 0 1em 0 2em;">
                    <div class="column">
                        <h4 class="ui header">
                            <img class="ui image" src="{{ asset('/img/icons/manage_ads_512.png') }}">
                            <div class="content">
                                {{ trans('sell.details') }}
                            </div>
                        </h4>
                        <ul class="ui list">
                            <li>{{ trans('sell.details_info_one') }}</li>
                            <li>{{ trans('sell.details_info_two') }}</li>
                        </ul>
                    </div>

                    <div class="column">
                        <h4 class="ui header">
                            <img class="ui image" src="{{ asset('/img/icons/manage_ads_512.png') }}">
                            <div class="content">
                                {{ trans('sell.promotion') }}
                            </div>
                        </h4>
                        <ul class="ui list">
                            <li>{{ trans('sell.promotion_info_one') }}</li>
                            <li>{{ trans('sell.promotion_info_two') }}</li>
                            <li>{{ trans('sell.promotion_info_three') }}</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection