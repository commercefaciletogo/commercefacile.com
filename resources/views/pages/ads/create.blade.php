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

        .form-field{
            display: flex; flex-direction: row; justify-content: flex-start; align-content: center;
        }
    </style>
@endsection

@section('main')

    <div id="main">
        <div class="ui container center aligned" style="padding-top: 1.5em; padding-bottom: 5em; background: #fff; border-left: 1px solid #a4acbe; border-right: 1px solid #a4acbe;">

            <h2 class="header" style="margin-bottom: 1em; color: #33446d;">Submit An Ad</h2>

            <div class="ui two column centered grid">
                <div class="twelve wide computer fourteen wide tablet fourteen wide mobile column" style="color: #33446d;">

                    <div class="ui dividing header" style="text-transform: capitalize; font-weight: normal;">Ad Information</div>

                    <div class="ui grid row">
                        <div class="three wide computer three wide tablet only column"><label>Ad's title</label></div>
                        <div class="eight wide computer eight wide tablet sixteen wide mobile column">
                            <div class="ui small fluid input">
                                <input type="text" v-model="newAd.title" placeholder="Ad's Title">
                            </div>
                        </div>
                        <div class="five wide computer tablet only column">
                            <div class="ui left pointing label">
                                That name is taken!That name is taken!That name is taken!
                            </div>
                        </div>
                    </div>

                    <div class="ui grid row">
                        <div class="three wide computer three wide tablet only column"><label>Ad's Category</label></div>
                        <div class="eight wide computer eight wide tablet sixteen wide mobile column">
                            <div class="ui right action fluid small input">
                                <input type="text" placeholder="Ad's Category">
                                <div class="ui basic floating button">
                                    Choose
                                    <i class="dropdown icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="five wide computer tablet only column">
                            <div class="ui left pointing label">
                                That name is taken!That name is taken!That name is taken!
                            </div>
                        </div>
                    </div>

                    <div class="ui grid row">
                        <div class="three wide computer three wide tablet only column"><label>Ad's Description</label></div>
                        <div class="eight wide computer eight wide tablet sixteen wide mobile column">
                            <div class="ui small fluid input">
                                <textarea cols="50" rows="10">Ad's Description...</textarea>
                            </div>
                        </div>
                        <div class="five wide computer tablet only column">
                            <div class="ui left pointing label">
                                That name is taken!That name is taken!That name is taken!
                            </div>
                        </div>
                    </div>

                    <div class="ui grid row">
                        <div class="three wide computer three wide tablet only column"><label>Ad's Image(s)</label></div>
                        <div class="eight wide computer eight wide tablet sixteen wide mobile column">
                            <div class="ui grid">
                                <div class="six wide computer tablet column">
                                    <div style="position: relative;overflow: hidden;">
                                        <input type="file" class="custom" @change="addImage" style="position: absolute; top: 0;bottom: 0;left: 0;right: 0;opacity: 0.001;">
                                        <button class="ui tiny button inp act" style="cursor: pointer;">
                                            + Image
                                        </button>
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
                            <div class="ui left pointing label">
                                That name is taken!That name is taken!That name is taken!
                            </div>
                        </div>
                    </div>

                    <div class="ui grid row">
                        <div class="three wide computer three wide tablet only column"><label>Ad's Price</label></div>
                        <div class="eight wide computer eight wide tablet sixteen wide mobile column">
                            <div class="ui right labeled fluid input">
                                <input type="text" placeholder="Ad's Price">
                                <div class="ui basic label" style="font-weight: 100;">FCFA</div>
                            </div>
                        </div>
                        <div class="five wide computer tablet only column">
                            <div class="ui left pointing label">
                                That name is taken!That name is taken!That name is taken!
                            </div>
                        </div>
                    </div>

                    <div class="ui dividing header" style="text-transform: capitalize; font-weight: normal;">Your Information</div>

                    <div class="ui grid row">
                        <div class="three wide computer three wide tablet only column"><label>Full Name</label></div>
                        <div class="eight wide computer eight wide tablet sixteen wide mobile column">
                            <div class="ui small fluid input">
                                <input type="text" v-model="newAd.title" placeholder="Full Name">
                            </div>
                        </div>
                        <div class="five wide computer tablet only column">
                        </div>
                    </div>

                    <div class="ui grid row">
                        <div class="three wide computer three wide tablet only column"><label>Phone Number</label></div>
                        <div class="eight wide computer eight wide tablet sixteen wide mobile column">
                            <div class="ui fluid small input">
                                <input type="text" placeholder="Phone Number">
                            </div>
                        </div>
                        <div class="five wide computer tablet only column">
                        </div>
                    </div>

                    <div class="ui grid row">
                        <div class="three wide computer three wide tablet only column"><label>Email</label></div>
                        <div class="eight wide computer eight wide tablet sixteen wide mobile column">
                            <div class="ui fluid small input">
                                <input type="text" placeholder="Email">
                            </div>
                        </div>
                        <div class="five wide computer tablet only column">
                        </div>
                    </div>

                    <div class="ui grid row">
                        <div class="three wide computer three wide tablet only column"><label>Location</label></div>
                        <div class="eight wide computer eight wide tablet sixteen wide mobile column">
                            <div class="ui right action fluid small input">
                                <input type="text" placeholder="Location">
                                <div data-remodal-target="choose-category" class="ui basic floating button">
                                    Change
                                    <i class="dropdown icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="five wide computer tablet only column">
                        </div>
                    </div>

                    <div class="ui grid row">
                        <div class="eight wide computer eight wide tablet only column">
                            <button @click.prevent="preview" class="ui submit button">Preview</button>
                        </div>
                        <div class="eight wide computer eight wide tablet sixteen wide mobile column right aligned">
                            <button @click.prevent="submit" class="ui submit button">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="remodal" data-remodal-id="choose-category" id="chooseCategory" data-remodal-options="closeOnOutsideClick: false">
            <button data-remodal-action="close" class="remodal-close"></button>
            <div class="ui styled accordion">
                <option-item @selected="closeModal"  v-for="category in categories" :item="category"></option-item>
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