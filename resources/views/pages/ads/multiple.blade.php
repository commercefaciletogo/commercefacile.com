@extends('partials.master._pages')

@section('styles')
    <style>

        #ad-view{
            max-height: 150px;
            max-width: 500px;
        }

        .elsipzise{
            overflow: hidden;
            text-overflow: ellipsis;
            -webkit-line-clamp: 2;
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

            div.mobile-ads-box{
                padding: 0 !important;
            }

            div.column.ad_info{
                width: 185px !important;
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


        <div class="ui container fluid" style="padding-top: .5em; padding-bottom: 10em;">

            <div class="ui container">

                <div class="big-search row" style="margin-top: 2em;padding: .5em; background-color: #fff; border-bottom: 2px solid #d1d5de;">
                    <div class="ui stackable centered grid">
                        <div class="column row">
                            <div class="eight wide column search-modifier">
                                <div class="ui grid">
                                    <div class="eight wide column">
                                        <button data-remodal-target="choose-location" class="ui fluid right labeled icon button search-modifier-button" style="border: 1px solid #606e8d !important;">
                                            <i class="dropdown icon"></i>
                                            <span v-cloak>@{{ transLocation }}</span>
                                        </button>
                                    </div>
                                    <div class="eight wide column">
                                        <button data-remodal-target="choose-category" class="ui fluid right labeled icon button search-modifier-button" style="border: 1px solid #606e8d !important;">
                                            <i class="dropdown icon"></i>
                                            <span v-cloak>@{{ transCategory }}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="eight wide column search-input">
                                <form @submit.prevent="updateSearchQuery" class="ui form" style="margin-bottom: 0 !important;">
                                    <div class="ui action small fluid input">
                                        <input v-model="filter.q" style="border-radius: 0; border: 1px solid #606e8d !important; padding: .4em;" type="text" placeholder="Search...">
                                        <button type="submit" style="border: 1px solid #606e8d !important; border-radius: 0; background: #606e8d; color: white;" class="ui button">{{ trans('general.search') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-cloak v-if="result" id="result-info" style="margin-top: 1em;padding: .5em; background-color: #fff; border-bottom: 2px solid #d1d5de;">
                    <div class="ui two column mobile only grid">
                        <div class="column" style="display: flex; flex-direction: column; justify-content: center; margin-bottom: 10px;">
                            @{{ ads.total }} {{ trans('general.ads') }}
                            <span v-show="filter.q">
                                {{ trans('general.for') }}
                                <i v-text="filter.q"></i>
                            </span>
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
                                    <div class="ui form">
                                        <div class="grouped fields">
                                            <label>{{ trans('general.sort') }}:</label>
                                            <div v-cloak class="field">
                                                <div class="ui radio checkbox">
                                                    <input id="recentAds"
                                                           v-model="filter.sort"
                                                           value="r"
                                                           type="radio">
                                                    <label for="recentAds">{{ trans('general.recent_ads') }}</label>
                                                </div>
                                            </div>
                                            <div v-cloak class="field">
                                                <div class="ui radio checkbox">
                                                    <input id="lowestPrice"
                                                           v-model="filter.sort"
                                                           value="l"
                                                           type="radio">
                                                    <label for="lowestPrice">{{ trans('general.lowest_price') }}</label>
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
                            <div v-cloak :class="['ui segment', {loading:busy}]" style="box-shadow: none; border: 0;">

                                <div v-if="result" class="ui two column computer tablet only grid">
                                    <div class="ten wide computer sixteen wide tablet column">
                                        <div>
                                            @{{ ads.from }}-@{{ ads.to }} {{ trans('general.of') }} @{{ ads.total }} {{ trans('general.ads') }}
                                            <span v-show="filter.q">
                                                {{ trans('general.for') }}  <i v-text="filter.q"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Ads Display --}}

                                <component :is="currentView" :ads="ads.data"></component>

                                <paginate v-if="paginate"
                                        :page-count="ads.last_page"
                                        :click-handler="handlePaginate"
                                        :prev-text="'Prev'"
                                        :next-text="'Next'"
                                        :container-class="'className'">
                                </paginate>
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
                    <div v-cloak class="grouped fields">
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input id="recentAdsMobile" type="radio" value="r" v-model="filter.sort">
                                <label for="recentAdsMobile" >{{ trans('general.recent_ads') }}</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui radio checkbox">
                                <input id="lowestPriceMobile" type="radio" value="l" v-model="filter.sort">
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
                {{--<hr>--}}
                {{--<div class="ui fluid submit button">{{ trans('general.close') }}</div>--}}
            </div>
        </div>
    </div>



@endsection

@section('scripts')
    <script>
        var baseUrl = "{{ route('ads.multiple.search') }}";
        var singleAdUrl = "{{ route('ads.multiple') }}";
        $(function(){
            $('#chooseCategory').accordion();
            $('#chooseLocation').accordion();
            $('#lgCategoryFilter').accordion();
            $('#lgLocationFilter').accordion();
            $('.ui.accordion.field').accordion();
        });
    </script>
    <script src="https://b86068563707f1548c7c-cc73bb3144250bf95e4a0690bc25f5d2.ssl.cf5.rackcdn.com/assets/multiple.js"></script>
@endsection
