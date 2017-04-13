@extends('partials.master._auth')

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

        <div class="ui container" style="background: #fff; padding-bottom: 5em; border-bottom: 4px solid #d1d5de; margin-top: 2em;">

            <div class="ui two column centered grid">
                <div class="column center aligned">
                    <div class="ui huge header" style="color: #4a597d;">{{ trans('terms.header') }}</div>
                </div>
                <div class="column stackable row" style="padding: 0 1em 0 2em;">
                    <div class="column" style="">
                        {!! trans('terms.content') !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection