@extends('partials.master._auth')

@section('main')
    <div id="main" style="margin-bottom: 5em;">

        <div class="ui container" style="background: #fff; padding-bottom: 5em; border-bottom: 4px solid #d1d5de; margin-top: 2em;">

            <div class="ui two column centered grid">
                <div class="column center aligned">
                    <h1 class="ui header">
                        {{ trans('safe.header') }}
                        <div class="sub header" style="font-size: .45em !important;">{{ trans('safe.sub_header') }}</div>
                    </h1>
                </div>
                <div class="column stackable row" style="padding: 1em 1em 0 2em;">
                    <div class="column">
                        <h3 class="ui header">
                            <img class="ui image" src="{{ asset('/img/icons/manage_ads_512.png') }}">
                            <div class="content">
                                {{ trans('safe.general') }}
                            </div>
                        </h3>
                        <ul class="ui list">
                            <li>
                                <p>
                                    <strong>Lorem ipsum dolor sit amet</strong>, consectetur adipisicing elit. Accusantium aut consequuntur facere id molestias nemo, obcaecati perspiciatis placeat porro quae repudiandae tempora unde veritatis. Ab architecto enim facere necessitatibus optio!
                                </p>
                            </li>
                            <li>
                                <p>
                                    <strong>Lorem ipsum dolor sit amet</strong>, consectetur adipisicing elit. Accusantium aut consequuntur facere id molestias nemo, obcaecati perspiciatis placeat porro quae repudiandae tempora unde veritatis. Ab architecto enim facere necessitatibus optio!
                                </p>
                            </li>
                            <li>
                                <p>
                                    <strong>Lorem ipsum dolor sit amet</strong>, consectetur adipisicing elit. Accusantium aut consequuntur facere id molestias nemo, obcaecati perspiciatis placeat porro quae repudiandae tempora unde veritatis. Ab architecto enim facere necessitatibus optio!
                                </p>
                            </li>
                        </ul>
                    </div>

                    <div class="column">
                        <h3 class="ui header">
                            <img class="ui image" src="{{ asset('/img/icons/manage_ads_512.png') }}">
                            <div class="content">
                                {{ trans('safe.scams') }}
                            </div>
                        </h3>
                        <ul class="ui list">
                            <li>
                                <p>
                                    <strong>Lorem ipsum dolor sit amet</strong>, consectetur adipisicing elit. Accusantium aut consequuntur facere id molestias nemo, obcaecati perspiciatis placeat porro quae repudiandae tempora unde veritatis. Ab architecto enim facere necessitatibus optio!
                                </p>
                            </li>
                            <li>
                                <p>
                                    <strong>Lorem ipsum dolor sit amet</strong>, consectetur adipisicing elit. Accusantium aut consequuntur facere id molestias nemo, obcaecati perspiciatis placeat porro quae repudiandae tempora unde veritatis. Ab architecto enim facere necessitatibus optio!
                                </p>
                            </li>
                            <li>
                                <p>
                                    <strong>Lorem ipsum dolor sit amet</strong>, consectetur adipisicing elit. Accusantium aut consequuntur facere id molestias nemo, obcaecati perspiciatis placeat porro quae repudiandae tempora unde veritatis. Ab architecto enim facere necessitatibus optio!
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="column stackable row" style="padding: 2em 1em 0 2em;">
                    <div class="column">
                        <h3 class="ui header">
                            <img class="ui image" src="{{ asset('/img/icons/manage_ads_512.png') }}">
                            <div class="content">
                                {{ trans('safe.measures') }}
                            </div>
                        </h3>
                        <ul class="ui list">
                            <li>
                                <p>
                                    <strong>Lorem ipsum dolor sit amet</strong>, consectetur adipisicing elit. Accusantium aut consequuntur facere id molestias nemo, obcaecati perspiciatis placeat porro quae repudiandae tempora unde veritatis. Ab architecto enim facere necessitatibus optio!
                                </p>
                            </li>
                            <li>
                                <p>
                                    <strong>Lorem ipsum dolor sit amet</strong>, consectetur adipisicing elit. Accusantium aut consequuntur facere id molestias nemo, obcaecati perspiciatis placeat porro quae repudiandae tempora unde veritatis. Ab architecto enim facere necessitatibus optio!
                                </p>
                            </li>
                            <li>
                                <p>
                                    <strong>Lorem ipsum dolor sit amet</strong>, consectetur adipisicing elit. Accusantium aut consequuntur facere id molestias nemo, obcaecati perspiciatis placeat porro quae repudiandae tempora unde veritatis. Ab architecto enim facere necessitatibus optio!
                                </p>
                            </li>
                        </ul>
                    </div>

                    <div class="column">
                        <h3 class="ui header">
                            <img class="ui image" src="{{ asset('/img/icons/manage_ads_512.png') }}">
                            <div class="content">
                                {{ trans('safe.report') }}
                            </div>
                        </h3>
                        <ul class="ui list">
                            <li>
                                <p>
                                    <strong>Lorem ipsum dolor sit amet</strong>, consectetur adipisicing elit. Accusantium aut consequuntur facere id molestias nemo, obcaecati perspiciatis placeat porro quae repudiandae tempora unde veritatis. Ab architecto enim facere necessitatibus optio!
                                </p>
                            </li>
                            <li>
                                <p>
                                    <strong>Lorem ipsum dolor sit amet</strong>, consectetur adipisicing elit. Accusantium aut consequuntur facere id molestias nemo, obcaecati perspiciatis placeat porro quae repudiandae tempora unde veritatis. Ab architecto enim facere necessitatibus optio!
                                </p>
                            </li>
                            <li>
                                <p>
                                    <strong>Lorem ipsum dolor sit amet</strong>, consectetur adipisicing elit. Accusantium aut consequuntur facere id molestias nemo, obcaecati perspiciatis placeat porro quae repudiandae tempora unde veritatis. Ab architecto enim facere necessitatibus optio!
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection