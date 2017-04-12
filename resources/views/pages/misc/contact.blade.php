@extends('partials.master._pages')

@section('styles')
    <style>
        @media only screen and (max-width: 767px){
            .ui.grid > .stackable.stackable.row > .column{
                min-width: 85% !important;
            }
        }
    </style>
@endsection

@section('main')
    <div id="main" style="margin-bottom: 5em;">

        @include('partials.pages.home._top_bar')

        <div class="ui container" style="background: #fff; padding-bottom: 5em; border-bottom: 4px solid #d1d5de; margin-top: 2em;">

            <div class="ui two column centered grid">
                <div class="column center aligned">
                    <div class="ui huge header" style="color: #4a597d;">{{ trans('contact.header') }}</div>
                </div>
                <div class="column stackable row" style="padding: 0 1em 0 2em;">
                    <div class="column" style="">
                        <h3 class="ui header">
                            <div class="content">
                                {{ trans('contact.message') }}
                                <div style="font-size: .7em;" class="sub header">{{ trans('contact.sub_message') }}</div>
                            </div>
                        </h3>
                        <form class="ui form">
                            <div class="field">
                                <label>{{ trans('contact.name') }}</label>
                                <input type="text" name="name" required>
                            </div>
                            <div class="field">
                                <label>Email</label>
                                <input type="email" required name="email">
                            </div>
                            <div class="field">
                                <label>Measage</label>
                                <textarea required></textarea>
                            </div>
                            <button class="ui button" type="submit">{{ trans('contact.send') }}</button>
                        </form>
                    </div>
                </div>
                <div class="column stackable row" style="padding: 0 1em 0 2em;">
                    <div class="column">
                        <h3 class="ui header">
                            <div class="content">
                                {{ trans('contact.helpline') }}
                                <div style="font-size: .7em;" class="sub header">{{ trans('contact.sub_helpline') }}</div>
                            </div>
                        </h3>
                        <div class="ui tiny statistic">
                            <div class="value">
                                00228 9011 07 35
                            </div>
                            <div class="value">
                                00228 9011 07 35
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection