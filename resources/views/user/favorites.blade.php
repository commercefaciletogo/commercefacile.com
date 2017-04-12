@extends('partials.master._profile')

@section('styles')

    <style></style>

@endsection

@section('meta')
    @include('partials.profile._meta', ['user' => auth('user')->user()])
@endsection


@section('content')

    <div class="ui container">
        <div class="row">
            <div class="ui centered grid">
                <div class="eight wide computer ten wide tablet sixteen wide mobile column">
                    @forelse($ads as $ad)
                        <a href="{{ route('ads.single', ['id' => $ad['uuid']]) }}" style="width: 322px; color: #1d305d; margin-right: .5em; margin-bottom: .5em;">
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
                    @empty
                        <p>No Favorites</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

@endsection