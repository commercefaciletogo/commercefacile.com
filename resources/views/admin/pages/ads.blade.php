@extends('partials.admin._page')

@section('main')

    <div id="main">

        <div class="ui top attached segment">
            <div v-cloak class="ui three column grid">
                <div class="four wide column">
                    <div class="ui mini horizontal statistic">
                        <div v-cloak class="value">
                        </div>
                        <div class="label">
                            {{ trans('general.ads') }}
                        </div>
                    </div>
                </div>
                <div class="six wide column">
                    <div class="ui grid">
                        <div class="twelve wide column">
                            <form style="margin-bottom: 0;" @submit.prevent="search">
                                <div class="ui mini fluid icon input">
                                    <input v-model="query" type="text">
                                    <i @click="search" class="circular search link icon"></i>
                                </div>
                            </form>
                        </div>
                        <div class="tow wide column">
                            <button v-show="showReset" @click="resetSearch" v-cloak class="ui basic icon mini button">
                                <i class="remove icon"></i>
                            </button>
                        </div>
                        <div class="two wide column">
                            <div v-show="loading" class="ui active inline small loader"></div>
                        </div>
                    </div>
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

            <ads-table :status="currentStatus" api-url="{!! route('api.ads') !!}"></ads-table>

        </div>

    </div>

@endsection

@section('scripts')
    <script>
        var adsApiUrl = "{!! route('api.ads') !!}";
        var adsUrl = "{!! route('admin.ads') !!}";
        var adminRoleId = "{{ auth('admin')->user()->role->id }}";
    </script>
    @if(App::environment('local'))
        <script src="{{ asset('js/admin-page-ads.js') }}"></script>
    @else
        <script src="https://b86068563707f1548c7c-cc73bb3144250bf95e4a0690bc25f5d2.ssl.cf5.rackcdn.com/assets/admin-page-ads.js"></script>
    @endif
@endsection