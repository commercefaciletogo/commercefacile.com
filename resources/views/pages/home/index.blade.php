@extends('partials.master._pages')

@section('styles')

    <style>
        #main{
            display: flex;
            flex-direction: column;
        }
    </style>

@endsection

@section('main-menu')
    @include('partials.pages._top_bar')
@endsection

@section('main')
    <div id="main">
        @include('partials.pages.home._jumbo')


        <div class="ui container">
            <div class="ui grid">

                <div style="height: 500px;" class="twelve wide column">

                    {{--<latest-ads></latest-ads>--}}

                    <p  style="font-size: 1.5em; color: #1d305d;">
                        Latest Ads
                    </p>
                    <div class="ui segments" style="
                        border: 0;
                        box-shadow: none;
                        border-radius: 0;
                    ">
                        <div class="ui segment" style="
                            padding-top: 0;
                            border: 0;
                            box-shadow: none;
                            border-radius: 0;
                        ">
                            <p style="font-size: 1.2em; color: #4a597d;">Electronics</p>
                            <div style="width: 400px; color: #1d305d; display: inline-block; margin-right: .5em;">
                                <div class="ui container" style="background-color: #e8eaee;">
                                    <div class="ui grid">
                                        <div class="column" style="padding: 0; width: 150px !important;">
                                            <img class="ui small image" src="{!! asset('img/usb_light.jpg') !!}" alt="">
                                        </div>
                                        <div class="column"  style="
                                    width: 222px !important;
                                    display: flex;
                                    flex-direction: column;
                                    justify-content: space-between;
                                ">
                                            <div class="row title" style="font-size: 1.5em;">
                                                <span>USB light</span>
                                            </div>
                                            <div class="row description">
                                                <span>usb light description</span>
                                            </div>
                                            <div class="row price" style="font-size: 2em; font-weight: bold;">
                                                350 ghc
                                            </div>
                                            <div class="row action">
                                                <button class="ui button mini">buy</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <div style="background-color: #e8eaee; height: 500px;" class="four wide column">
                    <div class="row" style="margin-bottom: 2em;">
                        <h3 class="ui dividing header">
                            Popular Cities
                        </h3>
                        <div class="ui list">
                            <div class="item">
                                <i class="users icon"></i>
                                <div class="content">
                                    Semantic UI
                                </div>
                            </div>
                            <div class="item">
                                <i class="marker icon"></i>
                                <div class="content">
                                    New York, NY
                                </div>
                            </div>
                            <div class="item">
                                <i class="mail icon"></i>
                                <div class="content">
                                    <a href="mailto:jack@semantic-ui.com">jack@semantic-ui.com</a>
                                </div>
                            </div>
                            <div class="item">
                                <i class="linkify icon"></i>
                                <div class="content">
                                    <a href="http://www.semantic-ui.com">semantic-ui.com</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h3 class="ui dividing header">
                            Popular Categories
                        </h3>
                        <div class="ui list">
                            <div class="item">
                                <i class="users icon"></i>
                                <div class="content">
                                    Semantic UI
                                </div>
                            </div>
                            <div class="item">
                                <i class="marker icon"></i>
                                <div class="content">
                                    New York, NY
                                </div>
                            </div>
                            <div class="item">
                                <i class="mail icon"></i>
                                <div class="content">
                                    <a href="mailto:jack@semantic-ui.com">jack@semantic-ui.com</a>
                                </div>
                            </div>
                            <div class="item">
                                <i class="linkify icon"></i>
                                <div class="content">
                                    <a href="http://www.semantic-ui.com">semantic-ui.com</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection