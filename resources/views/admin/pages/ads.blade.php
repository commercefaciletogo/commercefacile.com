@extends('partials.admin._page')

@section('main')

    <div id="main">

        <div class="ui top attached segment">
            <div v-cloak class="ui three column grid">
                <div class="four wide column">
                    <div class="ui mini horizontal statistic">
                        <div class="value">
                            {{--@{{ ads.total }}--}}
                        </div>
                        <div class="label">
                            {{ trans('general.ads') }}
                        </div>
                    </div>
                </div>
                <div class="six wide column">
                    {{--<div class="ui mini fluid icon input">--}}
                        {{--<input type="text" placeholder="Search...">--}}
                        {{--<i class="circular search link icon"></i>--}}
                    {{--</div>--}}
                </div>
                <div class="six wide right aligned column">
                    <div class="mini ui buttons">
                        <button
                                @click="changeStatus('pending')"
                                :class="['ui ', {active: currentStatus == 'pending'}, ' button']">{{ trans('general.pending') }}</button>
                        <button
                                @click="changeStatus('rejected')"
                                :class="['ui ', {active: currentStatus == 'rejected'}, ' button']">{{ trans('general.rejected') }}</button>
                        <button
                                @click="changeStatus('online')"
                                :class="['ui ', {active: currentStatus == 'online'}, ' button']">{{ trans('general.online') }}</button>
                        <button
                                @click="changeStatus('all')"
                                :class="['ui ', {active: currentStatus == 'all'}, ' button']">{{ trans('general.all') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui bottom attached segment">

            <ads-table :status="currentStatus" api-url="{!! LaravelLocalization::getLocalizedURL(null, route('api.ads')) !!}"></ads-table>

        </div>

    </div>

@endsection

@section('scripts')
    <script>
        var adsApiUrl = "{!! LaravelLocalization::getLocalizedURL(null, route('api.ads')) !!}";
        var adsUrl = "{!! LaravelLocalization::getLocalizedURL(null, route('admin.ads')) !!}";
    </script>
    <script src="{{ asset('js/admin-page-ads.js') }}"></script>
@endsection