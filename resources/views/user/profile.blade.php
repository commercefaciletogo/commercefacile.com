@extends('partials.master._profile')

@section('styles')

    <style>
        .pending{
            border-right: 1px solid #2185D0 !important;
        }

        .live{
            border-right: 1px solid #21BA45 !important;
        }

        .rejected{
            border-right: 1px solid #DB2828 !important;
        }

        .offline{
            border-right: 1px solid #E8E8E8 !important;
        }

        @media only screen and (max-width: 767px){
            .Ad__Item{
                padding-top: 0 !important;
            }
            .pending{
                border-right: none !important;
                border-top: 1px solid #2185D0 !important;
            }

            .live{
                border-right: none !important;
                border-top: 1px solid #21BA45 !important;
            }

            .rejected{
                border-right: none !important;
                border-top: 1px solid #DB2828 !important;
            }

            .offline{
                border-right: none !important;
                border-top: 1px solid #E8E8E8 !important;
            }
        }
    </style>

@endsection

@section('meta')
    @include('partials.profile._meta', ['user' => auth('user')->user()])
@endsection


@section('content')

    <div class="ui container">
        <div class="row">
            <div class="ui centered grid" style="padding-top: .5em;">
                <div class="fourteen wide computer fourteen wide tablet sixteen wide mobile column">

                    @forelse($ads as $ad)

                        <div class="ui stackable centered two column grid">

                                @if($ad['status'] == 'pending')
                                    <div class="mobile only column"
                                         style="display: flex; flex-direction: column; justify-content: flex-start; padding-bottom: 0 !important;">
                                    <div class="ui small blue bottom pointing label">
                                        <div class="ui two column grid">
                                            <div class="column">
                                                <p>
                                                    {{ trans('general.status') }}: {{ trans('general.pending') }}
                                                </p>
                                            </div>
                                            <div class="right aligned column">
                                                <a href="{{ route('ads.single.edit', ['id' => $ad['uuid']]) }}" class="ui mini basic {{ $ad['editable'] ? '' : 'disabled' }} compact icon button" style="color: white !important; border:1px solid white !important; box-shadow: none !important;">
                                                    <i class="icon pencil"></i>
                                                </a>
                                                <form method="post" action="{{ route('ads.single.delete', ['id' => $ad['id']]) }}" style="display: inline-block;">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="ui mini basic compact icon button"
                                                            style="color: white !important; border:1px solid white !important; box-shadow: none !important;">
                                                        <i class="icon trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <p>
                                            {{ trans('general.since') }}: {{ $ad['start_date'] }}
                                        </p>
                                    </div>
                                </div>
                                @elseif($ad['status'] == 'rejected')
                                    <div class="mobile only column" style="display: flex; flex-direction: column; justify-content: flex-start; padding-bottom: 0 !important;">
                                    <div class="ui small red bottom pointing label">
                                        <div class="ui two column grid">
                                            <div class="column">
                                                <p>
                                                    {{ trans('general.status') }}: {{ trans('general.rejected') }}
                                                </p>
                                            </div>
                                            <div class="right aligned column">
                                                <a href="{{ route('ads.single.edit', ['id' => $ad['uuid']]) }}" class="ui mini basic compact icon button" style="color: white !important; border:1px solid white !important; box-shadow: none !important;">
                                                    <i class="icon pencil"></i>
                                                </a>
                                                <form method="post" action="{{ route('ads.single.delete', ['id' => $ad['id']]) }}" style="display: inline-block;">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="ui mini basic compact icon button"
                                                            style="color: white !important; border:1px solid white !important; box-shadow: none !important;">
                                                        <i class="icon trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <p>
                                            {{ trans('general.since') }}: {{ $ad['start_date'] }}
                                        </p>
                                        <p>
                                            {{ $ad['rejected_fields'] }}
                                        </p>
                                    </div>
                                </div>
                                @elseif($ad['status'] == 'online')
                                    <div class="mobile only column" style="display: flex; flex-direction: column; justify-content: flex-start; padding-bottom: 0 !important;">
                                    <div class="ui small green bottom pointing label">
                                        <p>
                                            {{ trans('general.status') }}: {{ trans('general.online') }}
                                        </p>
                                        <p>
                                            {{ trans('general.since') }}: {{ $ad['start_date'] }}
                                        </p>
                                        <p>
                                            {{ trans('general.going_off_on') }}: {{ $ad['end_date'] }}
                                        </p>
                                    </div>
                                </div>
                                @elseif($ad['status'] == 'offline')
                                    <div class="mobile only column" style="display: flex; flex-direction: column; justify-content: flex-start; padding-bottom: 0 !important;">
                                    <div class="ui small ash bottom pointing label">
                                        <div class="ui two column grid">
                                            <div class="column">
                                                <p>
                                                    {{ trans('general.status') }}: {{ trans('general.offline') }}
                                                </p>
                                            </div>
                                            <div class="right aligned column">
                                                <div class="ui mini basic compact icon button">
                                                    <i class="icon send"></i>
                                                </div>
                                                <div class="ui mini basic compact icon button">
                                                    <i class="icon trash"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <p>
                                            {{ trans('general.since') }}: {{ $ad['start_date'] }}
                                        </p>
                                    </div>
                                </div>
                                @endif

                                <div class="eight wide computer eight wide tablet column Ad__Item" style="padding-top: 0 !important;">
                                    <div style="width: 323px; color: #1d305d;"
                                         @if($ad['status'] == 'pending')
                                            class="pending"
                                         @elseif($ad['status'] == 'rejected')
                                            class="rejected"
                                         @elseif($ad['status'] == 'online')
                                            class="live"
                                         @else
                                             class="offline"
                                         @endif

                                    >
                                        <div class="ui container" style="background-color: #fcfcfd;">
                                            <div class="ui grid" style="margin: 0;">
                                                <div class="column" style="padding: 0; width: 100px !important;">
                                                    <img class="ui image" src="{!! asset($ad['image']) !!}" alt="">
                                                </div>
                                                <div class="column"  style="width: 222px!important;display: flex; flex-direction: column; justify-content: space-between;">
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
                                    </div>
                                </div>

                                @if($ad['status'] == 'pending')
                                        <div class="eight wide computer tablet only column">
                                            <div class="ui small blue left pointing label" style="min-width: 250px !important;">
                                                <div class="ui two column grid">
                                                    <div class="column">
                                                        <p>
                                                            {{ trans('general.status') }}: {{ trans('general.pending') }}
                                                        </p>
                                                    </div>
                                                    <div class="right aligned column">
                                                        <a href="{{ route('ads.single.edit', ['id' => $ad['uuid']]) }}" class="ui mini basic {{ $ad['editable'] ? '' : 'disabled' }} compact icon button" style="color: white !important; border:1px solid white !important; box-shadow: none !important;">
                                                            <i class="icon pencil"></i>
                                                        </a>
                                                        <form onsubmit="return confirm('{{ trans('general.sure?') }}');" method="post" action="{{ route('ads.single.delete', ['id' => $ad['id']]) }}" style="display: inline-block;">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <button type="submit" class="ui mini basic compact icon button"
                                                                    style="color: white !important; border:1px solid white !important; box-shadow: none !important;">
                                                                <i class="icon trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <p>
                                                    {{ trans('general.since') }}: {{ $ad['start_date'] }}
                                                </p>
                                            </div>
                                        </div>
                                @elseif($ad['status'] == 'rejected')
                                        <div class="eight wide computer eight wide tablet only column">
                                            <div class="ui small red left pointing label">
                                                <div class="ui two column grid">
                                                    <div class="column">
                                                        <p>
                                                            {{ trans('general.status') }}: {{ trans('general.rejected') }}
                                                        </p>
                                                    </div>
                                                    <div class="right aligned column">
                                                        <a href="{{ route('ads.single.edit', ['id' => $ad['uuid']]) }}" class="ui mini basic compact icon button" style="color: white !important; border:1px solid white !important; box-shadow: none !important;">
                                                            <i class="icon pencil"></i>
                                                        </a>
                                                        <form method="post" action="{{ route('ads.single.delete', ['id' => $ad['id']]) }}" style="display: inline-block;">
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <button type="submit" class="ui mini basic compact icon button"
                                                                    style="color: white !important; border:1px solid white !important; box-shadow: none !important;">
                                                                <i class="icon trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>

                                                <p>
                                                    {{ trans('general.since') }}: {{ $ad['start_date'] }}
                                                </p>
                                                <p>
                                                    {{ $ad['rejected_fields'] }}
                                                </p>
                                            </div>
                                        </div>
                                @elseif($ad['status'] == 'online')
                                        <div class="eight wide computer tablet only column">
                                            <div class="ui small green left pointing label">
                                                <p>
                                                    {{ trans('general.status') }}: {{ trans('general.online') }}
                                                </p>
                                                <p>
                                                    {{ trans('general.since') }}: {{ $ad['start_date'] }}
                                                </p>
                                                <p>
                                                    {{ trans('general.going_off_on') }}: {{ $ad['end_date'] }}
                                                </p>
                                            </div>
                                        </div>
                                @elseif($ad['status'] == 'offline')
                                        <div class="eight wide computer eight wide tablet only column">
                                            <div class="ui small ash left pointing label" style="min-width: 225px;">
                                                <div class="ui two column grid">
                                                    <div class="column">
                                                        <p>
                                                            {{ trans('general.status') }}: {{ trans('general.offline') }}
                                                        </p>
                                                    </div>
                                                    <div class="right aligned column">
                                                        <div class="ui mini basic compact icon button">
                                                            <i class="icon send"></i>
                                                        </div>
                                                        <div class="ui mini basic compact icon button">
                                                            <i class="icon trash"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <p>
                                                    {{ trans('general.since') }}: {{ $ad['start_date'] }}
                                                </p>
                                            </div>
                                        </div>
                                @endif

                        </div>

                    @empty
                        <p>{{ trans('general.no_ad') }}</p>
                    @endforelse



                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.min.js"></script>
    <script>
        var authorId = "{!! auth('user')->user()->id !!}";
    </script>
    <script src="https://b86068563707f1548c7c-cc73bb3144250bf95e4a0690bc25f5d2.ssl.cf5.rackcdn.com/assets/user-profile.js"></script>
@endsection