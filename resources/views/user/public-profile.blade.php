@extends('partials.master._auth')


@section('styles')

    <style>
        .header{
            color: #1d305d !important;
        }
        .bottom-bar{
            border-bottom: 2px solid rgb(209, 213, 222);
        }

        .slick-prev, .slick-next{
            height: 20px;
            border-radius: 10px;
            background: transparent;
        }

        .slick-prev:before, .slick-next:before{
            line-height: 0;
            font-size: 15px;
            color: #1d305d;
        }

        .slick-prev:before{
            content: '←';
        }

        .slick-next:before{
            content: '→';
        }

        .slick-prev:hover, .slick-next:hover{
            height: 20px;
        }

        @media only screen and (max-width: 767px){
            .ui.tiny.image.Author_Avatar{
                max-width: 100px !important;
            }
        }
    </style>

@endsection


@section('main')

    <div id="main" style=" color: #1d305d !important;">
        <div class="ui container" style="background: #fff; border-left: 1px solid #a4acbe; border-right: 1px solid #a4acbe; min-height: 67vh;">

            <div class="row bottom-bar" style="padding: 1em; margin-bottom: 2em;">
                <div class="ui grid" style="">
                    <div class="column">
                        <div class="ui items">
                            <div class="item">
                                <div class="ui tiny image Author_Avatar">
                                    <img src="{{ asset('img/icons/user.png') }}">
                                </div>
                                <div class="middle aligned content">
                                    <div class="header">
                                        {{ title_case($user['name']) }}
                                    </div>
                                    <div class="extra">
                                        <div class="ui mini horizontal divided list">
                                            <div class="item">
                                                <img class="ui avatar image" src="{{ asset('img/icons/city.png') }}">
                                                <div class="content">
                                                    <div class="header" >{{ $user['location']['name'] }}</div>
                                                </div>
                                            </div>
                                            <div class="show phone item" style="cursor:pointer;">
                                                <img class="ui avatar image" src="{{ asset('img/icons/electronics.png') }}">
                                                <div class="content">
                                                    <div class="header">{{ $user['phone'][0] }}xxxxxxxx</div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <img class="ui avatar image" src="{{ asset('img/icons/manage_ads_512.png') }}">
                                                <div class="content">
                                                    <div class="header">{{ $total }}</div>
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

            <div class="row">
                <div class="ui two column centered grid">
                    <div class="ten wide computer twelve wide tablet sixteen wide mobile column">
                        <div class="ui segments" style="border: 0; box-shadow: none; border-radius: 0;">
                            <div class="ui segment" style="background: transparent; padding: 0; border: 0; box-shadow: none; border-radius: 0; margin-bottom: 2em;">

                                @forelse($categories as $category => $ads)
                                    <div class="ui container" style="margin-bottom: 1em; border-bottom: 2px solid rgb(209, 213, 222);">
                                        <div class="row" style="padding: .5em; background: #606e8d;">
                                            <a style="font-size: 1.2em; color: white; ">{{ $category }}</a>
                                        </div>

                                        <div class="row" style="background: transparent;">
                                            <div class="ads-slide" style="height: 100px;">
                                                @foreach($ads as $ad)
                                                    <a href="{{ route('ads.single', ['id' => $ad['uuid']]) }}" style="width: 322px; color: #1d305d; margin-right: .5em;">
                                                        <div class="ui container" style="background-color: #fcfcfd;">
                                                            <div class="ui grid" style="margin: 0;">
                                                                <div class="column" style="padding: 0; width: 100px !important;">
                                                                    <img class="ui image" src="{!! $ad['image'] !!}" alt="">
                                                                </div>
                                                                <div class="column"  style="width: 222px!important;display: flex;flex-direction: column;justify-content: space-between;">
                                                                    <div class="row title" style="font-size: 1.5em;">
                                                                        <span>{{ $ad['title'] }}</span>
                                                                    </div>
                                                                    <div class="row description" style="color: #77829d;">
                                                                        <span>{{ $ad['description'] }}</span>
                                                                    </div>
                                                                    <div class="row price" style="font-size: 1.2em;">
                                                                        {{ $ad['price'] }} FCFA
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                @empty
                                    <p>{{ trans('general.no_ad') }}</p>
                                @endforelse

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $('.ads-slide').slick({
            // infinite: true,
            slidesToShow: 2,
            slidesToScroll: 1,
            variableWidth: true,
            autoplay: true,
            autoplaySpeed: 5000
        });

        $('.show.phone').popup({
            content: "{{ $user['phone'] }}",
            on: 'click'
        });

    </script>
@endsection