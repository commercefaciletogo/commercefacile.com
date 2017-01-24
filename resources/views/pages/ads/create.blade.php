@extends('partials.master._auth')

@section('styles')
    <style>
        .ui.form .field label{
            color: #33446d;
        }

        .ui.form .field .ui.tiny.preview.images{
            /*border-top: dotted 1px #33446d;*/
            /*border-bottom: dotted 1px #e8eaee;*/
        }

        .ui.form .inp.act {
            background: #fff;
            border: 1px dotted #33446d;
            color: #33446d;
        }

        .ui.form .inp.act:hover {
            background: #d1d5de;
            color: #33446d;
        }
    </style>
@endsection

@section('main')

    <div id="main">
        <div class="ui container center aligned" style="padding-top: 4em; padding-bottom: 5em; background: #fff; border-left: 1px solid #a4acbe; border-right: 1px solid #a4acbe;">

            <h2 class="header" style="margin-bottom: 2em; color: #33446d;">Submit An Ad</h2>

            <div class="ui two column centered grid">
                <div class="nine wide column" style="color: #33446d;">
                    <div class="ui middle aligned very relaxed stackable grid">
                        <div class="column">
                            <form class="ui form" style="">
                                {{--<div class="ui divider horizontal">Your Ad Information</div>--}}
                                <div class="field required">
                                    <label>Ad's title</label>
                                    <div class="ui icon input">
                                        <input type="text" v-model="newAd.title">
                                        <div class="ui left pointing label">
                                            That name is taken!
                                        </div>
                                    </div>
                                </div>
                                <div class="ui divider horizontal" style="text-transform: capitalize;"></div>

                                <div class="field required">
                                    <label>Ad's Category</label>
                                    <div class="ui action input">
                                        <input type="text" v-model="newAd.category.text" readonly>
                                        <div class="ui button inp act pointing dropdown link item" id="selectCategory">
                                            <span class="text" v-text="dropButtonName">Choose</span>
                                            <i class="dropdown icon"></i>
                                            <div class="menu">
                                                <option-item v-for="category in categories" :item="category"></option-item>
                                            </div>
                                        </div>
                                        <div class="ui left pointing label">
                                            That name is taken!
                                        </div>
                                    </div>
                                </div>
                                <div class="ui divider horizontal" style="text-transform: capitalize;"></div>

                                <div class="field required">
                                    <label>Ad's Description</label>
                                    <div class="ui icon input">
                                        <textarea v-model="newAd.description"></textarea>
                                        <div class="ui left pointing label">
                                            That name is taken!
                                        </div>
                                    </div>
                                </div>
                                <div class="ui divider horizontal" style="text-transform: capitalize;"></div>

                                <div class="inline fields">
                                    <div class="twelve wide field required" style="margin-right: 2em;">
                                        <div class="ui right pointing label">
                                                That name is taken!
                                            </div>
                                        <label style="color: #33446d;">Ad's Photo(s)</label>
                                        
                                    </div>
                                    <div class="four wide field" style="">
                                        <div class="file upload">
                                            <div class="" style="
                                                position: relative;
                                                overflow: hidden;
                                            ">
                                                <input type="file" class="custom" @change="addImage" style="
                                                    position: absolute;
                                                    top: 0;
                                                    bottom: 0;
                                                    left: 0;
                                                    right: 0;
                                                    opacity: 0.001;
                                                ">
                                                <button class="ui button inp act" style="cursor: pointer;">
                                                    Add Image
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="ui tiny preview images">
                                        <image-preview v-for="file in newAd.photos" @remove="removeImage" :src="file">
                                    </div>
                                </div>
                                <div class="ui divider horizontal" style="text-transform: capitalize;"></div>

                                <div class="tow fields">
                                    <div class="field required">
                                        <label>Ad's Price</label>
                                        <div class="ui right labeled icon input">
                                            <input type="text" v-model="newAd.price.amount">
                                            <div class="ui basic label" style="color: #33446d;">
                                                FCFA
                                            </div>
                                            <div class="ui left pointing label">
                                            That name is taken!
                                        </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="ui divider horizontal" style="text-transform: capitalize;"></div>

                                <div class="inline fields">
                                    <div class="field required">
                                    <div class="ui right pointing label">
                                            That name is taken!
                                        </div>
                                        <label style="color: #33446d;">Ad's Price is Negotiable?</label>
                                    </div>
                                    <div class="field">
                                        <div class="ui radio">
                                            <input type="radio" v-model="newAd.price.negotiable" :value="true" tabindex="0" class="hidden">
                                            <label>Yes</label>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="ui radio">
                                            <input type="radio" v-model="newAd.price.negotiable" :value="false" tabindex="0" class="hidden">
                                            <label>No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="ui divider horizontal" style="text-transform: capitalize;"></div>
                                <div class="ui divider horizontal" style="text-transform: capitalize;"></div>
                                <div class="ui divider horizontal" style="text-transform: capitalize;"></div>
                                <div class="ui divider horizontal" style="text-transform: capitalize; color: #33446d;">Your Information</div>
                                <div class="field">
                                    <label>Location</label>
                                    <div class="ui action input">
                                        <input type="text" v-model="user.location.text" readonly>
                                        <div class="ui button inp act pointing dropdown link item" id="selectLocation">
                                            <span class="text" v-text="dropButtonName">Choose</span>
                                            <i class="dropdown icon" style="color: #4a597d;"></i>
                                            <div class="menu">
                                                <option-item v-for="location in locations" :item="location"></option-item>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <label>Name</label>
                                    <div class="ui icon input">
                                        <input readonly type="text">
                                        <i class="user icon" style="color: #4a597d;"></i>
                                    </div>
                                </div>
                                <div class="field">
                                    <label>Email</label>
                                    <div class="ui icon input">
                                        <input readonly type="text" >
                                        <i class="mail icon" style="color: #4a597d;"></i>
                                    </div>
                                </div>
                                <div class="field">
                                    <label>Phone Number</label>
                                    <div class="ui icon input">
                                        <input readonly type="text">
                                        <i class="phone icon" style="color: #4a597d;"></i>
                                    </div>
                                </div>
                                <div class="ui divider horizontal"></div>
                                <div class="ui container two column grid">
                                    <div class="ui container left aligned column">
                                        <button @click.prevent="preview" class="ui submit button">Preview</button>
                                    </div>
                                    <div class="column right aligned">
                                        <button @click.prevent="submit" class="ui submit button">Submit</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="ui modal categories">
            <div class="header" v-text="selectedCategory.name">Choose Category</div>
            <div class="content">
                <div class="ui two column grid">
                    <div class="column">
                        <categories @selected="fetchSub"></categories>
                    </div>
                    <div class="column">
                        <sub-categories @selected="closeModal" :categories="selectedCategory.sub_categories"></sub-categories>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/create.js') }}"></script>
@endsection