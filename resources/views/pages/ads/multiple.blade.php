@extends('partials.master._pages')

@section('styles')
    <style>

        #ad-view{
            max-height: 150px;
            max-width: 500px;
        }

        #ad-view:hover{
            cursor: pointer;
        }

        .ui.fluid.button.search-modifier-button{
            background: #606e8d;
            color: white;
            border-radius: 0;
            text-overflow: ellipsis !important;
            overflow: hidden;
            white-space: nowrap;
        }

        .ui.styled.accordion{
            box-shadow: none;
        }

        #result-info{
            display: none;
        }

        @media only screen and (min-width: 1920px){

        }

        @media only screen and (max-width: 1919px) and (min-width: 1200px){

        }

        @media only screen and (max-width: 1199px) and (min-width: 992px){

        }

        @media only screen and (max-width: 991px) and (min-width: 768px){

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

            #result-info{
                display: block;
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
                                        <button v-cloak data-remodal-target="choose-location" class="ui fluid right labeled icon button search-modifier-button" style="border: 1px solid #606e8d !important;">
                                            <i class="dropdown icon"></i>
                                            @{{ search.location.text }}
                                        </button>
                                    </div>
                                    <div class="eight wide column">
                                        <button v-cloak data-remodal-target="choose-category" class="ui fluid right labeled icon button search-modifier-button" style="border: 1px solid #606e8d !important;">
                                            <i class="dropdown icon"></i>
                                            @{{ search.category.text }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="eight wide column search-input">
                                <div class="ui action small fluid input">
                                    <input v-model="search.q" style="border-radius: 0; border: 1px solid #606e8d !important; padding: .4em;" type="text" placeholder="Search...">
                                    <button style="border: 1px solid #606e8d !important; border-radius: 0; background: #606e8d; color: white;" class="ui button">{{ trans('general.search') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="result-info" style="margin-top: 1em;padding: .5em; background-color: #fff; border-bottom: 2px solid #d1d5de;">
                    <div class="ui two column mobile only grid">
                        <div class="column" style="display: flex; flex-direction: column; justify-content: center;">
                            <span style="color: rgb(96, 110, 141); ">{{ trans('general.ads_count', ['number' => '12,045']) }}</span>
                        </div>
                        <div class="column right aligned">
                            <div class="ui mini basic button" data-remodal-target="filter" style="border-color: rgb(96, 110, 141); color: rgb(96, 110, 141); border-radius: 0;"> <i class="filter icon"></i> {{ trans('general.filter') }}</div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 2em;padding: .5em; background-color: #fff; border-bottom: 2px solid #d1d5de; min-height: 50vh;">
                    <div class="ui grid">
                        <div class="four wide computer five wide tablet only column">
                            <div class="ui container" style="padding-right: .5em;border-right: 1px solid #d1d5de;">
                                <div class="row" style="margin-top: 1em; margin-left: 1em;">
                                    <div class="ui mini form">
                                        <div class="field">
                                            <label>{{ trans('general.sort') }}:</label>
                                            <div class="ui selection dropdown">
                                                <input type="hidden">
                                                <i class="dropdown icon"></i>
                                                <div class="default text">{{ trans('general.sort') }}...</div>
                                                <div class="menu">
                                                    <div class="item" data-value="recentAds">{{ trans('general.recent_ads') }}</div>
                                                    <div class="item" data-value="lowestPrice">{{ trans('general.lowest_price') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 1em;">
                                    <div class="ui styled accordion" id="lgCategoryFilter">
                                        <div class="active title">
                                            <i class="dropdown icon"></i>
                                            {{ trans('general.categories') }}
                                        </div>
                                        <div class="active content" style="padding: 0 0 0 1em;">
                                            <component :items="categories" 
                                                type="category" 
                                                @back="goBack" 
                                                goBackLabel="All Categories" 
                                                :parent="selectedCategory" 
                                                :subs="subCategories" 
                                                :is="currentSelectionCategory" 
                                                @selected="handleSelected"></component>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 1em;">
                                    <div class="ui styled accordion" id="lgLocationFilter">
                                        <div class="active title">
                                            <i class="dropdown icon"></i>
                                            {{ trans('general.popular_cities') }}
                                        </div>
                                        <div class="active content" style="padding: 0 0 0 1em;">
                                            <component :items="locations" 
                                                type="location" 
                                                @back="goBack" 
                                                goBackLabel="All Locations" 
                                                :parent="selectedLocation" 
                                                :subs="cities" 
                                                :is="currentSelectionLocation" 
                                                @selected="handleSelected"></component>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="twelve wide computer eleven wide tablet sixteen wide mobile column">
                            <div class="ui two column computer tablet only grid">
                                <div class="ten wide computer sixteen wide tablet column">
                                    <div style="margin-top: 1em; padding-top: 1em;">
                                        1-25 of 13,545 {{ trans('general.ads') }} {{ trans('general.for') }}  <i>iphone</i>
                                    </div>
                                </div>
                            </div>
                            <div class="ui segment" id="ad-view" style="padding: 0; box-shadow: none; border-radius: 0; border-right: 0; border-left: 0;">
                                <div style="width: 322px; color: #1d305d;">
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
                            <div class="ui segment" id="ad-view" style="padding: 0; box-shadow: none; border-radius: 0; border-right: 0; border-left: 0;">
                                <div style="width: 322px; color: #1d305d;">
                                    <div class="ui container" style="background-color: #fcfcfd;">
                                        <div class="ui grid" style="margin: 0;">
                                            <div class="column" style="padding: 0; width: 100px !important;">
                                                <img class="ui image" src="{!! asset('img/icons/hoody_100.jpg') !!}" alt="">
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

    <div class="remodal" data-remodal-id="choose-category" id="chooseCategory" data-remodal-options="closeOnOutsideClick: false">
        <button data-remodal-action="close" class="remodal-close"></button>
        <div class="ui container left aligned">
            <div class="ui styled accordion">
                <option-item @selected="closeCategoryModal"  v-for="category in categories" :item="category"></option-item>
            </div>
        </div>
    </div>

    <div class="remodal" data-remodal-id="choose-location" id="chooseLocation" data-remodal-options="closeOnOutsideClick: false">
        <button data-remodal-action="close" class="remodal-close"></button>
        <div class="ui container left aligned">
            <div class="ui styled accordion">
                <option-item @selected="closeLocationModal"  v-for="location in locations" :item="location"></option-item>
            </div>
        </div>
    </div>

    {{--mobile phones--}}
    <div class="remodal" data-remodal-id="filter" id="performFilterModal" data-remodal-options="closeOnOutsideClick: false" style="background: #e8eaee; padding: 15px;">
        <button data-remodal-action="close" style="color: #FB344B" class="remodal-close"></button>
        <div class="ui segment left aligned" style="box-shadow: none; border: 0; background: transparent;">
            <div class="ui fluid tiny form">
                <div class="inline fields">
                    <label>{{ trans('general.sort') }}:</label>
                    <div class="grouped fields">
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input id="recentAdsMobile" type="radio" value="recentAds" name="sort" v-model="filter.sort">
                                <label for="recentAdsMobile" >{{ trans('general.recent_ads') }}</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input id="lowestPriceMobile" type="radio" value="lowestPrice" name="sort" v-model="filter.sort">
                                <label for="lowestPriceMobile" >{{ trans('general.lowest_price') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="ui accordion field">
                    <div class="title">
                        <i class="icon dropdown"></i>
                        {{ trans('general.category') }} : @{{ filter.category.name }}
                    </div>
                    <div class="content field">
                        <div class="ui styled sub-field accordion ">
                            <option-item @selected="closeCategoryFilter"  v-for="category in categories" :item="category"></option-item>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="ui accordion field">
                    <div class="title">
                        <i class="icon dropdown"></i>
                        {{ trans('general.location') }}: @{{ filter.location.name }}
                    </div>
                    <div class="content field">
                        <div class="ui styled accordion sub-field">
                            <option-item @selected="closeLocationFilter"  v-for="location in locations" :item="location"></option-item>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="ui fluid submit button" @click="performFilter">{{ trans('general.filter') }}</div>
        </div>
    </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/multiple.js') }}"></script>
@endsection
