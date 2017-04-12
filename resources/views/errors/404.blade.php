@extends('partials.master._pages')

@section('main')
    <div class="ui container fluid" id="main">

        @include('partials.pages.home._top_bar')

        <div class="ui container" style="padding-top: .5em; margin-bottom: 10em;">

            <div class="ui container grid" style="margin-top: 1em;height: 100px;">

                <div class="sixteen wide column ui container center aligned">
                    <div class="ui huge header" style="color: #4a597d;">{{ trans('general.page_not_found') }}</div>
                </div>

                <div class="sixteen wide column ui container center aligned">
                    <form action="{{ route('ads.multiple') }}" class="ui form s" method="get">
                        <div class="ui fluid left icon action input main-search">
                            <i class="search icon"></i>
                            <input required type="text" name="q" placeholder="{{ trans('general.what_are_you_looking_for') }}">
                            <button style="border-radius: 0;" type="submit" class="ui button search-button">{{ trans('general.search') }}</button>
                        </div>
                    </form>
                    <a href="{{ route('ads.multiple') }}" class="ui button" style="margin-top: 1em; background: #f79520; color: #606e8d;">{{ trans('general.all_ads') }}</a>
                </div>
            </div>

        </div>
    </div>
@endsection