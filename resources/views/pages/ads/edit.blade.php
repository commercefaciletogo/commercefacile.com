@extends('partials.master._auth')

@section('styles')
    <style>
        .ui.form .field label, label, .ui.dividing.header{
            color: #33446d !important;
        }

        .ui.small.left.pointing.label{
            font-weight: 300;
            color: #33446d;
        }

        label.inp.act {
            background: #fff;
            border: 1px dotted #33446d;
            color: #33446d;
            cursor: pointer;
        }

        label.inp.act:hover {
            background: #d1d5de;
            color: #33446d;
        }

        textarea.error, label.inp.act.error {
            background-color: #FFF6F6;
            border-color: #E0B4B4;
            color: #9F3A38 !important;
            box-shadow: none;
        }

        .form-field{
            display: flex; flex-direction: row; justify-content: flex-start; align-content: center;
        }

        textarea, input{
            color: #4a597d !important;
            border-radius: 0;
        }

        textarea{
            border-color: rgba(34, 36, 38, 0.15);
            border-radius: 0.28571429rem;
            resize: none;
            padding: 0.67861429em 1em;
        }

        textarea::placeholder{
            color: blue;
        }

        textarea:focus, input:focus{
            border-color: #4a597d !important;
            color: #4a597d !important;
        }

        div.ui.styled.accordion{
            background: transparent !important;
            box-shadow: none;
            border-radius: 0;
        }

        div.remodal{
            background: #e8eaee;
            max-width: 400px !important;
        }

        button.remodal-close{
            color: #FB344B;
        }
    </style>
@endsection

@section('main')

    <div id="main">
        <div class="ui container center aligned" style="padding-top: 1.5em; padding-bottom: 5em; background: #fff; border-left: 1px solid #a4acbe; border-right: 1px solid #a4acbe;">

            <h2 class="header" style="margin-bottom: 1em; color: #33446d;">{{ trans('general.edit_ad') }}</h2>

            <div :class="['ui ', {loading:busy}, ' segment']" style="padding: 0; border: none; box-shadow: none;">
                <div class="ui two column centered grid">
                    <div class="twelve wide computer fourteen wide tablet fourteen wide mobile column" style="color: #33446d;">

                        <div class="ui dividing header" style="text-transform: capitalize; font-weight: normal;">{{ trans('general.ad_information') }}</div>

                        <div class="ui grid row">
                            <div class="three wide computer three wide tablet only column"><label>{{ trans('general.ad_title') }}</label></div>
                            <div class="eight wide computer eight wide tablet sixteen wide mobile column">
                                <div v-cloak :class="['ui small fluid', {error: errors.title}, 'input']">
                                    <input type="text" v-model="newAd.title" placeholder="{{ trans('general.ad_title') }}">
                                </div>
                            </div>
                            <div class="five wide computer tablet only column">
                                <div class="ui small left pointing label">
                                    <p>
                                        {{ trans('general.ad_title_suggest') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="ui grid row">
                            <div class="three wide computer three wide tablet only column"><label>{{ trans('general.ad_category') }}</label></div>
                            <div class="eight wide computer eight wide tablet sixteen wide mobile column">
                                <div v-cloak :class="['ui right action fluid small', {error: errors.category} , 'input']">
                                    <input type="text" v-model="newAd.category.text" readonly placeholder="{{ trans('general.ad_category') }}">
                                    <div class="ui basic floating button" data-remodal-target="choose-category">
                                        <i class="dropdown icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="five wide computer tablet only column">
                                {{--<div class="ui small left pointing label">--}}
                                {{--<p>--}}
                                {{--{{ trans('general.ad_category_suggest') }}--}}
                                {{--</p>--}}
                                {{--</div>--}}
                            </div>
                        </div>

                        <div class="ui grid row">
                            <div class="three wide computer three wide tablet only column"><label>{{ trans('general.condition') }}</label></div>
                            <div class="eight wide computer eight wide tablet sixteen wide mobile column">
                                <div class="ui grid">
                                    <div class="eight wide column">
                                        <div class="ui radio checkbox">
                                            <input id="new" type="radio" value="1" v-model="newAd.condition">
                                            <label for="new" >{{ trans('general.new') }}</label>
                                        </div>
                                    </div>
                                    <div class="eight wide column">
                                        <div class="ui radio checkbox">
                                            <input id="used" type="radio" value="0" v-model="newAd.condition">
                                            <label for="used">{{ trans('general.used') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="five wide computer tablet only column">
                                <div class="ui small left pointing label">
                                    <p>
                                        {{ trans('general.ad_condition_suggest') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="ui grid row">
                            <div class="three wide computer three wide tablet only column"><label>{{ trans('general.ad_description') }}</label></div>
                            <div class="eight wide computer eight wide tablet sixteen wide mobile column">
                                <div class="ui small fluid input">
                                    <textarea v-cloak :class="[{error: errors.description}]" v-model="newAd.description" maxlength="500" minlength="20" cols="50" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="five wide computer tablet only column">
                                <div class="ui small left pointing label">
                                    <p>
                                        {{ trans('general.ad_description_suggest') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="ui grid row">
                            <div class="three wide computer three wide tablet only column"><label>{{ trans('general.ad_images') }}</label></div>
                            <div class="eight wide computer eight wide tablet sixteen wide mobile column">
                                <div class="ui grid">
                                    <div class="six wide computer tablet column">
                                        <div style="position: relative;overflow: hidden;">
                                            <input id="fileInput" accept="image/jpg" type="file" class="custom" @change="addImage" style="position: absolute; top: 0;bottom: 0;left: 0;right: 0;opacity: 0.001; display: none;">
                                            <label v-cloak for="fileInput" :class="[moreImageDefaultStyle, errors.images ? 'error' : '', moreImage ? '' : 'disabled']" style="cursor: pointer;">
                                                + Image
                                            </label>
                                        </div>
                                    </div>
                                    <div class="ten wide computer tablet column">
                                        <div class="ui tiny preview images">
                                            <image-preview v-for="file in newAd.photos" @remove="removeImage" :src="file">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="five wide computer tablet only column">
                                <div class="ui small left pointing label">
                                    <p>
                                        {{ trans('general.ad_photo_suggest') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="ui grid row">
                            <div class="three wide computer three wide tablet only column"><label>{{ trans('general.ad_price') }}</label></div>
                            <div class="eight wide computer eight wide tablet sixteen wide mobile column">
                                <div class="ui grid">
                                    <div class="ten wide column">
                                        <div v-cloak :class="['ui right small labeled fluid', {error: errors.price}, 'input']">
                                            <input v-model="newAd.price.amount" type="number" placeholder="{{ trans('general.ad_price') }}">
                                            <div class="ui basic label" style="font-weight: 100; color: #4a597d;">FCFA</div>
                                        </div>
                                    </div>
                                    <div class="six wide column" style="display: flex; flex-direction: column; justify-content: center;">
                                        <div class="ui checkbox">
                                            <input id="negotiable" v-model="newAd.price.negotiable" type="checkbox">
                                            <label for="negotiable">{{ trans('general.negotiable') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="five wide computer tablet only column">
                                <div class="ui small left pointing label">
                                    <p>
                                        {{ trans('general.ad_price_suggest') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{--<div class="ui dividing header" style="text-transform: capitalize; font-weight: normal;">{{ trans('general.your_information') }}</div>--}}

                        {{--<div class="ui grid row">--}}
                            {{--<div class="three wide computer three wide tablet only column"><label>{{ trans('general.full_name') }}</label></div>--}}
                            {{--<div class="eight wide computer eight wide tablet sixteen wide mobile column">--}}
                                {{--<div class="ui small fluid input">--}}
                                    {{--<input type="text" readonly value="{!! ucwords(Auth::guard('user')->user()->name) !!}" placeholder="{{ trans('general.full_name') }}">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="five wide computer tablet only column">--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="ui grid row">--}}
                            {{--<div class="three wide computer three wide tablet only column"><label>{{ trans('general.phone_number') }}</label></div>--}}
                            {{--<div class="eight wide computer eight wide tablet sixteen wide mobile column">--}}
                                {{--<div class="ui right labeled fluid small input">--}}
                                    {{--<div class="ui basic label" style="color: #4a597d;">+228</div>--}}
                                    {{--<input style="border-right-color: rgba(34, 36, 38, 0.15) !important;" type="text" value="{!! Auth::guard('user')->user()->phone !!}" readonly placeholder="{{ trans('general.phone_number') }}">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="five wide computer tablet only column">--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="ui grid row">--}}
                        {{--<div class="three wide computer three wide tablet only column"><label>{{ trans('general.email') }}</label></div>--}}
                        {{--<div class="eight wide computer eight wide tablet sixteen wide mobile column">--}}
                        {{--<div class="ui fluid small input">--}}
                        {{--<input type="text" v-model="user.email" readonly placeholder="{{ trans('general.email') }}">--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="five wide computer tablet only column">--}}
                        {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="ui grid row">--}}
                            {{--<div class="three wide computer three wide tablet only column"><label>{{ trans('general.location') }}</label></div>--}}
                            {{--<div class="eight wide computer eight wide tablet sixteen wide mobile column">--}}
                                {{--<div class="ui small fluid input">--}}
                                    {{--<input type="text" readonly value="{!! ucwords(Auth::guard('user')->user()->location->name) !!}" placeholder="{{ trans('general.full_name') }}">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="five wide computer tablet only column">--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <div class="ui grid row">
                            <div class="three wide computer three wide tablet sixteen wide mobile column right aligned">
                                <button @click.prevent="cancel" class="ui fluid button">{{ trans('general.cancel') }}</button>
                            </div>
                            <div class="eight wide computer eight wide tablet only column">
                            </div>
                            <div class="three wide computer three wide tablet sixteen wide mobile column right aligned">
                                <button v-cloak @click.prevent="submit" :class="['ui fluid ', {loading:submitting}, ' button']">{{ trans('general.submit') }}</button>
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

    </div>

@endsection

@section('scripts')
    <script>
        var oldAd = {!! json_encode($ad) !!};
        var profileUrl = "{!! route('user.profile', ['user_name' => auth('user')->user()->slug]) !!}";
        var authorId = "{!! auth('user')->user()->uuid !!}";
        var requireLocation = "{!! is_null(auth('user')->user()->location) !!}";
        var updateAdUrl = "{!! route('ads.single.update', ['id' => $ad['id']]) !!}";
        var cancelUpdateAdUrl = "{!! route('ads.single.update.cancel', ['id' => $ad['id']]) !!}";
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.min.js"></script>
    <script src="https://b86068563707f1548c7c-cc73bb3144250bf95e4a0690bc25f5d2.ssl.cf5.rackcdn.com/assets/edit.js"></script>
    {{--<script src="{{ asset('js/edit.js') }}"></script>--}}
@endsection