@extends('partials.master._pages')

@section('main')
    <div id="main" style="margin-bottom: 5em;">

        @include('partials.pages.home._top_bar')

        <div class="ui container" style="background: #fff; padding-bottom: 5em; border-bottom: 4px solid #d1d5de; margin-top: 2em;">

            <div class="ui two column centered grid">
                <div class="column center aligned">
                    <div class="ui huge header" style="color: #4a597d;">{{ trans('faq.header') }}</div>
                </div>
                <div class="column row" style="padding: 0 1em 0 1em;">
                    <div class="column" style="min-width: 100% !important; display: flex; justify-content: center;">
                        <div class="ui styled accordion">
                            <div class="active title">
                                <i class="dropdown icon"></i>
                                {!! trans('faq.one') !!}
                            </div>
                            <div class="active content">
                                {!! trans('faq.one_') !!}
                            </div>
                            <div class="title">
                                <i class="dropdown icon"></i>
                                {{ trans('faq.two') }}
                            </div>
                            <div class="content">
                                {!! trans('faq.two_') !!}
                            </div>
                            <div class="title">
                                <i class="dropdown icon"></i>
                                {!! trans('faq.three') !!}
                            </div>
                            <div class="content">
                                {{ trans('faq.three_') }}
                            </div>
                            <div class="title">
                                <i class="dropdown icon"></i>
                                {{ trans('faq.four') }}
                            </div>
                            <div class="content">
                                {!! trans('faq.four_') !!}
                            </div>
                            <div class="title">
                                <i class="dropdown icon"></i>
                                {{ trans('faq.five') }}
                            </div>
                            <div class="content">
                                {{ trans('faq.five_') }}
                            </div>
                            <div class="title">
                                <i class="dropdown icon"></i>
                                {{ trans('faq.six') }}
                            </div>
                            <div class="content">
                                {!! trans('faq.six_') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function(){
            $('.ui.accordion').accordion();
        });
    </script>
@endsection