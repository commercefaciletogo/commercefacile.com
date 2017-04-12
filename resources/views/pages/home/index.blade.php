@extends('partials.master._pages')

@section('styles')

    <style>
        #main{
            display: flex;
            flex-direction: column;
        }



        .slick-prev, .slick-next{
            height: 20px;
            border-radius: 10px;
            background: transparent;
        }

        .slick-prev:before, .slick-next:before{
            line-height: 0;
            font-size: 15px;
            color: #1d305d;
        }

        .slick-prev:before{
            content: '←';
        }

        .slick-next:before{
            content: '→';
        }

        .slick-prev:hover, .slick-next:hover{
            height: 20px;
        }
    </style>

@endsection



@section('main')
    <div class="ui container fluid" id="main">

        @include('partials.pages.home._top_bar')

        <div class="ui container fluid" style="padding-top: .5em; margin-bottom: 10em;">

            {{--computer--}}
            <div class="ui container computer only grid" style="margin-top: 1em;height: 100px;display: flex; flex-direction: column; justify-content: center; align-content: center;">
                <div class="four wide tablet five wide column">
                    <img src="{{ asset('/img/logos/logo_w_d.png') }}" alt="" class="ui image">
                </div>
                <div class="seven wide tablet eight wide computer column ui container center aligned">
                    <form action="{{ route('ads.multiple') }}" class="ui form s" method="get">
                        <div class="ui fluid left icon action input main-search">
                            <i class="search icon"></i>
                            <input type="text" required name="q" placeholder="{{ trans('general.what_are_you_looking_for') }}">
                            <button type="submit" style="border-radius: 0;" class="ui button search-button">{{ trans('general.search') }}</button>
                        </div>
                    </form>
                </div>
                <div class="five wide tablet three wide computer column ui container center aligned">
                    <a href="{{ route('ads.multiple') }}" class="ui button fluid all-ads" style="color: #1d305d;">{{ trans('general.all_ads') }}</a>
                </div>
            </div>

            {{--Tablet--}}
            <div class="ui container tablet only grid" style="margin-top: .7em;height: 70px;display: flex; flex-direction: column; justify-content: center; align-content: center;">

                <div class="eleven wide column ui container center aligned">
                    <form action="{{ route('ads.multiple') }}" class="ui form s" method="get">
                        <div class="ui fluid left icon action input main-search">
                            <i class="search icon"></i>
                            <input type="text" required name="q" placeholder="{{ trans('general.what_are_you_looking_for') }}">
                            <button type="submit" style="border-radius: 0;" class="ui button search-button">{{ trans('general.search') }}</button>
                        </div>
                    </form>
                </div>
                <div class="five wide  column ui container center aligned">
                    <a href="{{ route('ads.multiple') }}" class="ui button fluid all-ads" style="color: #1d305d;">{{ trans('general.all_ads') }}</a>
                </div>
            </div>

            {{--Mobile Devices--}}
            <div class="ui container mobile only grid" style="display: flex; flex-direction: column; justify-content: center; align-content: center;">
                <div class="sixteen wide column ui container center aligned">
                    <form action="{{ route('ads.multiple') }}" class="ui form s" method="get">
                        <div class="ui fluid left icon action input main-search">
                            <i class="search icon"></i>
                            <input type="text" required name="q" placeholder="{{ trans('general.what_are_you_looking_for') }}">
                            <button type="submit" style="border-radius: 0;" class="ui button search-button">{{ trans('general.search') }}</button>
                        </div>
                    </form>
                    <a href="{{ route('ads.multiple') }}" class="ui button" style="margin-top: 1em; background: #f79520; color: #606e8d;">{{ trans('general.all_ads') }}</a>
                </div>
            </div>

            {{--tablet and computer only--}}
            <div class="ui container computer tablet only grid">
                <div class="twelve wide column">
                    @include('partials.pages.home._jumbo')
                </div>

                <div class="four wide column">
                    <div class="ui container" style="border-bottom: 2px solid rgb(209, 213, 222); background-color: white; color: rgb(74, 89, 125); padding: 1em; height: 350px;">
                        <div class="row" style="margin-bottom: 2em;">
                            <h3 class="ui dividing header" style="color: rgb(29, 48, 93);">
                                {{ trans('general.popular_cities') }}
                            </h3>
                            <div class="ui animated link items">
                                @foreach($cities as $city)
                                    <a class="item" style="height: 25px; color: rgb(74, 89, 125);"
                                       href="{{ qs_url(route('ads.multiple'), ['l' => $city->uuid]) }}">
                                        <div class="ui mini image" style="width: 25px; height: 25px;">
                                            <img src="{{ asset("/img/icons/city.png") }}">
                                        </div>
                                        <div class="middle aligned content" style="padding: 0 0 0 1em;">
                                            {{ $city['name'] }}
                                        </div>
                                    </a>
                                @endforeach
                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="ui container grid">
                <div class="sixteen wide mobile twelve wide computer twelve wide tablet column">

                    {{--<latest-ads></latest-ads>--}}

                    <div class="ui container" v-cloak>
                        <div class="row" style="border-bottom: 2px solid rgb(209, 213, 222); background: white; padding: .5em; margin-bottom: 1em;">
                            <a href="" style="font-size: 1.5em; color: #1d305d;">
                                {{ trans('general.latest_ads') }}
                            </a>
                        </div>

                        <div class="row" style="background: transparent;">
                            <div class="ui segments" style="border: 0; box-shadow: none; border-radius: 0;">
                                <div class="ui segment" style="background: transparent; padding: 0; border: 0; box-shadow: none; border-radius: 0; margin-bottom: 2em;">

                                    <div class="ui container" style="margin-bottom: 1em; border-bottom: 2px solid rgb(209, 213, 222);">
                                        <div class="row" style="padding: .5em; background: #606e8d;">
                                            <a href="" style="font-size: 1.2em; color: white; ">Phones & Tablets</a>
                                        </div>

                                        <div class="row" style="background: transparent;">
                                            <div class="ads-slide" style="height: 100px;">
                                                <div style="width: 322px; color: #1d305d; margin-right: .5em;">
                                                    <div class="ui container" style="background-color: #fcfcfd;">
                                                        <div class="ui grid" style="margin: 0;">
                                                            <div class="column" style="padding: 0; width: 100px !important;">
                                                                <img class="ui image" src="{!! asset('img/icons/usb_light.jpg') !!}" alt="">
                                                            </div>
                                                            <div class="column"  style="width: 222px!important;display: flex;flex-direction: column;justify-content: space-between;">
                                                                <div class="row title" style="font-size: 1.5em;">
                                                                    <span>USB light</span>
                                                                </div>
                                                                <div class="row description" style="color: #77829d;">
                                                                    <span>usb light description</span>
                                                                </div>
                                                                <div class="row price" style="font-size: 1.2em;">
                                                                    350 FCFA
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="width: 322px; color: #1d305d; margin-right: .5em;">
                                                    <div class="ui container" style="background-color: #fcfcfd;">
                                                        <div class="ui grid" style="margin: 0;">
                                                            <div class="column" style="padding: 0; width: 100px !important;">
                                                                <img class="ui image" src="{!! asset('img/icons/usb_light.jpg') !!}" alt="">
                                                            </div>
                                                            <div class="column"  style="width: 222px!important;display: flex;flex-direction: column;justify-content: space-between;">
                                                                <div class="row title" style="font-size: 1.5em;">
                                                                    <span>USB light</span>
                                                                </div>
                                                                <div class="row description" style="color: #77829d;">
                                                                    <span>usb light description</span>
                                                                </div>
                                                                <div class="row price" style="font-size: 1.2em;">
                                                                    350 FCFA
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="width: 322px; color: #1d305d; margin-right: .5em;">
                                                    <div class="ui container" style="background-color: #fcfcfd;">
                                                        <div class="ui grid" style="margin: 0;">
                                                            <div class="column" style="padding: 0; width: 100px !important;">
                                                                <img class="ui image" src="{!! asset('img/icons/usb_light.jpg') !!}" alt="">
                                                            </div>
                                                            <div class="column"  style="width: 222px!important;display: flex;flex-direction: column;justify-content: space-between;">
                                                                <div class="row title" style="font-size: 1.5em;">
                                                                    <span>USB light</span>
                                                                </div>
                                                                <div class="row description" style="color: #77829d;">
                                                                    <span>usb light description</span>
                                                                </div>
                                                                <div class="row price" style="font-size: 1.2em;">
                                                                    350 FCFA
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="ui container" style="margin-bottom: 1em; border-bottom: 2px solid rgb(209, 213, 222);">
                                        <div class="row" style="padding: .5em; background: #606e8d;">
                                            <a href="" style="font-size: 1.2em; color: white; ">Electronics</a>
                                        </div>

                                        <div class="row" style="background: #f5f6f8;">
                                            <div class="ads-slide" style="height: 100px;">
                                                <div style="width: 322px; color: #1d305d; margin-right: .5em;">
                                                    <div class="ui container" style="background-color: #fcfcfd;">
                                                        <div class="ui grid" style="margin: 0;">
                                                            <div class="column" style="padding: 0; width: 100px !important;">
                                                                <img class="ui image" src="{!! asset('img/icons/usb_light.jpg') !!}" alt="">
                                                            </div>
                                                            <div class="column"  style="width: 222px!important;display: flex;flex-direction: column;justify-content: space-between;">
                                                                <div class="row title" style="font-size: 1.5em;">
                                                                    <span>USB light</span>
                                                                </div>
                                                                <div class="row description" style="color: #77829d;">
                                                                    <span>usb light description</span>
                                                                </div>
                                                                <div class="row price" style="font-size: 1.2em;">
                                                                    350 FCFA
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="width: 322px; color: #1d305d; margin-right: .5em;">
                                                    <div class="ui container" style="background-color: #fcfcfd;">
                                                        <div class="ui grid" style="margin: 0;">
                                                            <div class="column" style="padding: 0; width: 100px !important;">
                                                                <img class="ui image" src="{!! asset('img/icons/usb_light.jpg') !!}" alt="">
                                                            </div>
                                                            <div class="column"  style="width: 222px!important;display: flex;flex-direction: column;justify-content: space-between;">
                                                                <div class="row title" style="font-size: 1.5em;">
                                                                    <span>USB light</span>
                                                                </div>
                                                                <div class="row description" style="color: #77829d;">
                                                                    <span>usb light description</span>
                                                                </div>
                                                                <div class="row price" style="font-size: 1.2em;">
                                                                    350 FCFA
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="width: 322px; color: #1d305d; margin-right: .5em;">
                                                    <div class="ui container" style="background-color: #fcfcfd;">
                                                        <div class="ui grid" style="margin: 0;">
                                                            <div class="column" style="padding: 0; width: 100px !important;">
                                                                <img class="ui image" src="{!! asset('img/icons/usb_light.jpg') !!}" alt="">
                                                            </div>
                                                            <div class="column"  style="width: 222px!important;display: flex;flex-direction: column;justify-content: space-between;">
                                                                <div class="row title" style="font-size: 1.5em;">
                                                                    <span>USB light</span>
                                                                </div>
                                                                <div class="row description" style="color: #77829d;">
                                                                    <span>usb light description</span>
                                                                </div>
                                                                <div class="row price" style="font-size: 1.2em;">
                                                                    350 FCFA
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="ui container" style="margin-bottom: 1em; border-bottom: 2px solid rgb(209, 213, 222);">
                                        <div class="row" style="padding: .5em; background: #606e8d;">
                                            <a href="" style="font-size: 1.2em; color: white; ">Clothing</a>
                                        </div>

                                        <div class="row" style="background: #f5f6f8;">
                                            <div class="ads-slide" style="height: 100px;">
                                                <div style="width: 322px; color: #1d305d; margin-right: .5em;">
                                                    <div class="ui container" style="background-color: #fcfcfd;">
                                                        <div class="ui grid" style="margin: 0;">
                                                            <div class="column" style="padding: 0; width: 100px !important;">
                                                                <img class="ui image" src="{!! asset('img/icons/usb_light.jpg') !!}" alt="">
                                                            </div>
                                                            <div class="column"  style="width: 222px!important;display: flex;flex-direction: column;justify-content: space-between;">
                                                                <div class="row title" style="font-size: 1.5em;">
                                                                    <span>USB light</span>
                                                                </div>
                                                                <div class="row description" style="color: #77829d;">
                                                                    <span>usb light description</span>
                                                                </div>
                                                                <div class="row price" style="font-size: 1.2em;">
                                                                    350 FCFA
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="width: 322px; color: #1d305d; margin-right: .5em;">
                                                    <div class="ui container" style="background-color: #fcfcfd;">
                                                        <div class="ui grid" style="margin: 0;">
                                                            <div class="column" style="padding: 0; width: 100px !important;">
                                                                <img class="ui image" src="{!! asset('img/icons/usb_light.jpg') !!}" alt="">
                                                            </div>
                                                            <div class="column"  style="width: 222px!important;display: flex;flex-direction: column;justify-content: space-between;">
                                                                <div class="row title" style="font-size: 1.5em;">
                                                                    <span>USB light</span>
                                                                </div>
                                                                <div class="row description" style="color: #77829d;">
                                                                    <span>usb light description</span>
                                                                </div>
                                                                <div class="row price" style="font-size: 1.2em;">
                                                                    350 FCFA
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="width: 322px; color: #1d305d; margin-right: .5em;">
                                                    <div class="ui container" style="background-color: #fcfcfd;">
                                                        <div class="ui grid" style="margin: 0;">
                                                            <div class="column" style="padding: 0; width: 100px !important;">
                                                                <img class="ui image" src="{!! asset('img/icons/usb_light.jpg') !!}" alt="">
                                                            </div>
                                                            <div class="column"  style="width: 222px!important;display: flex;flex-direction: column;justify-content: space-between;">
                                                                <div class="row title" style="font-size: 1.5em;">
                                                                    <span>USB light</span>
                                                                </div>
                                                                <div class="row description" style="color: #77829d;">
                                                                    <span>usb light description</span>
                                                                </div>
                                                                <div class="row price" style="font-size: 1.2em;">
                                                                    350 FCFA
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                {{--<div class="one wide column"></div>--}}

                <div class="four wide computer four wide tablet only column">
                    <div class="ui container" style="background-color: white; color: rgb(74, 89, 125); padding: 1em; border-bottom: 2px solid rgb(209, 213, 222);">
                        <div class="row">
                            <h3 class="ui dividing header" style="color: rgb(29, 48, 93);">
                                {{ trans('general.categories') }}
                            </h3>
                            <div class="ui link animated items">
                                @foreach($categories as $category)
                                    <a class="item" style="height: 25px;  color: rgb(74, 89, 125);"
                                       href="{{ qs_url(route('ads.multiple'), ['c' => $category['uuid']]) }}">
                                        <div class="ui mini image" style="width: 25px; height: 25px;">
                                            <img src="{{ asset("/img/icons/{$category['key']}.png") }}">
                                        </div>
                                        <div class="middle aligned content" style="padding: 0 0 0 1em;">
                                            {{ $category['name'] }}
                                        </div>
                                    </a>
                                @endforeach
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
//        $('.ads-slide').slick({
//            // infinite: true,
//            slidesToShow: 2,
//            slidesToScroll: 1,
//            variableWidth: true,
//            autoplay: true,
//            autoplaySpeed: 5000
//        });
    </script>
    <script src="js/home.js"></script>
@endsection