@extends('partials.master._auth')

@section('main')

    <div id="main">
        <div class="ui container center aligned" style="margin-top: 4em; margin-bottom: 5em;">

            <h2 class="header"  style="margin-bottom: 2em; color: #33446d;">Submit An Ad</h2>

            <div class="ui two column centered grid">
                <div class="column" style="background: #e8eaee;">
                    <div class="ui middle aligned very relaxed stackable grid">
                        <div class="column">
                            <form class="ui form">
                                <div class="ui divider horizontal">Your Ad Information</div>
                                <div class="field">
                                    <label>Ad's title</label>
                                    <div class="ui left icon input">
                                        <input type="text">
                                        <i class="pencil icon" style="color: #4a597d;"></i>
                                        <div class="ui left pointing label">
                                            That name is taken!
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <label>Ad's Category</label>
                                    <div class="ui icon input">
                                        <input type="text">
                                        <i class="angle down icon" style="color: #4a597d;"></i>
                                    </div>
                                </div>
                                <div class="field required">
                                    <label>Ad's Description</label>
                                    <div class="ui icon input">
                                        <textarea></textarea>
                                    </div>
                                </div>
                                <div class="fields">
                                    <div class="four wide field" style="margin-right: 2em;">
                                        <label>Ad's Photo(s)</label>
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
                                                <button class="ui button">
                                                    Add Image
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="twelve wide field">
                                        <div class="ui tiny images">
                                            <image-preview v-for="file in newAd.photos" @remove="removeImage" :src="file">
                                        </div>
                                    </div>
                                </div>
                                <div class="tow fields">
                                    <div class="field">
                                        <label>Ad's Price</label>
                                        <div class="ui right labeled icon input">
                                            <input type="text">
                                            <div class="ui basic label">
                                                FCFA
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="inline fields">
                                    <label>Ad's Price is Negotiable?</label>
                                    <div class="field">
                                        <div class="ui radio checkbox">
                                            <input type="radio" name="price" tabindex="0" class="hidden">
                                            <label>Yes</label>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="ui radio checkbox">
                                            <input type="radio" name="price" tabindex="0" class="hidden">
                                            <label>No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="ui divider horizontal">Your Information</div>
                                <div class="field">
                                    <label>Your Location</label>
                                    <div class="ui icon input">
                                        <input type="text" placeholder="City or suburb">
                                        <i class="angle down icon" style="color: #4a597d;"></i>
                                    </div>
                                </div>
                                <div class="field">
                                    <label>Your Name</label>
                                    <div class="ui icon input">
                                        <input type="text">
                                        <i class="angle down icon" style="color: #4a597d;"></i>
                                    </div>
                                </div>
                                <div class="field">
                                    <label>Your Email</label>
                                    <div class="ui icon input">
                                        <input type="text" >
                                        <i class="angle down icon" style="color: #4a597d;"></i>
                                    </div>
                                </div>
                                <div class="field">
                                    <label>Your Phone Number</label>
                                    <div class="ui icon input">
                                        <input type="text">
                                        <i class="angle down icon" style="color: #4a597d;"></i>
                                    </div>
                                </div>
                                <div class="ui divider horizontal"></div>
                                <div class="ui container two column grid">
                                    <div class="ui container right aligned column">
                                        <button type="submit" class="ui submit button">Preview</button>
                                    </div>
                                    <div class="column">
                                        <button type="submit" class="ui submit button right aligned">Submit</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/create.js') }}"></script>
@endsection