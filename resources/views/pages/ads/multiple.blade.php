@extends('partials.master._pages')

@section('styles')
    <style>

        #ad-view{
            max-height: 150px;
            max-width: 500px;
        }

        .ui.fluid.button.search-modifier-button{
            background: #606e8d;
            color: white;
            border-radius: 0;
        }

        .ui.styled.accordion{
            box-shadow: none;
        }

        @media only screen and (min-width: 1920px){
            #result-info{
                display: none;
            }
        }

        @media only screen and (max-width: 1919px) and (min-width: 1200px){
            #result-info{
                display: none;
            }
        }

        @media only screen and (max-width: 1199px) and (min-width: 992px){
            #result-info{
                display: none;
            }
        }

        @media only screen and (max-width: 991px) and (min-width: 768px){
            #result-info{
                display: none;
            }
        }

        @media only screen and (max-width: 767px){
            div.big-search{
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            div.search-modifier{
            }

            div.search-input{
            }
        }
    </style>
@endsection

@section('main')
    <div class="ui container fluid">

        @include('partials.pages._top_bar')

        <div class="ui container fluid" style="padding-top: .5em; margin-bottom: 10em;">

            <div class="ui container">

                <div class="big-search row" style="margin-top: 2em;padding: .5em; background-color: #fff; border-bottom: 2px solid #d1d5de;">
                    <div class="ui stackable centered grid">
                        <div class="column row">
                            <div class="eight wide column search-modifier">
                                <div class="ui grid">
                                    <div class="eight wide column">
                                        <button class="ui fluid button search-modifier-button" style="border: 1px solid #606e8d !important;">
                                            <i class="icon marker"></i>
                                            Location
                                        </button>
                                    </div>
                                    <div class="eight wide column">
                                        <button class="ui fluid button search-modifier-button" style="border: 1px solid #606e8d !important;">
                                            <i class="icon tag"></i>
                                            Category
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="eight wide column search-input">
                                <div class="ui action small fluid input">
                                    <input style="border-radius: 0; border: 1px solid #606e8d !important; padding: .4em;" type="text" placeholder="Search...">
                                    <button style="border: 1px solid #606e8d !important; border-radius: 0; background: #606e8d; color: white;" class="ui button">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="result-info" style="margin-top: 1em;padding: .5em; background-color: #fff; border-bottom: 2px solid #d1d5de;">
                    <div class="ui two column mobile only grid">
                        <div class="column">
                            <span>12,135 Ads</span>
                        </div>
                        <div class="column right aligned">
                            <div class="ui mini basic button">Filter</div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 2em;padding: .5em; background-color: #fff; border-bottom: 2px solid #d1d5de; min-height: 50vh;">
                    <div class="ui grid">
                        <div class="four wide computer five wide tablet only column">
                            <div class="ui container" style="padding-right: .5em;border-right: 1px solid #d1d5de;">
                                <div class="row" style="margin-top: 1em;">
                                    <div class="ui styled accordion">
                                        <div class="active title">
                                            <i class="dropdown icon"></i>
                                            Sort Result by:
                                        </div>
                                        <div class="active content">
                                            <select class="ui fluid dropdown">
                                                <option value="1">Most Recent</option>
                                                <option value="0">Lowest Price</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 1em;">
                                    <div class="ui styled accordion">
                                        <div class="active title">
                                            <i class="dropdown icon"></i>
                                            Categories
                                        </div>
                                        <div class="active content" style="padding: 0 0 0 1em;">
                                            <component @back="goBack" :parent="selectedCategory" :subs="subCategories" :is="currentSelection" @selected="handleSelected"></component>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 1em;">
                                    <div class="ui styled accordion">
                                        <div class="title">
                                            <i class="dropdown icon"></i>
                                            Locations
                                        </div>
                                        <div class="content">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="twelve wide computer eleven wide tablet sixteen wide mobile column">
                            <div class="ui two column computer tablet only grid">
                                <div class="ten wide computer sixteen wide tablet column">
                                    <div style="margin-top: 1em; padding-top: 1em;">
                                        Showing 1-25 of 13,545 ads for <i>iphone</i> in Togo
                                    </div>
                                </div>
                            </div>
                            <div class="ui segment" id="ad-view" style="padding: 0; box-shadow: none; border-radius: 0; border-right: 0; border-left: 0;">
                                <div class="ui grid">
                                    <div class="four wide column" style="padding-right: 0;">
                                        <img class="ui fluid image" src="{!! asset('img/usb_light.jpg') !!}" alt="">
                                    </div>
                                    <div class="twelve wide column" style="display: flex; flex-direction: column;">
                                        <div style="display: flex; flex-direction: column; justify-content: space-around; padding: .5em;">
                                            <h4 class="ui header">Usb Light</h4>
                                            <p>Location, Category</p>
                                            <p>Price</p>
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
@endsection

@section('scripts')
    <script src="{{ asset('js/multiple.js') }}"></script>
@endsection