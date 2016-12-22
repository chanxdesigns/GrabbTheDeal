@extends('layouts.master')

@section('description', 'Get exclusive '.ucfirst($search_query).' Offers, Deals, Coupons & Cashbacks by Shopping Online in India')
@section('keywords', ucfirst($search_query). ', Offers, Deals, Coupons, Cashbacks', 'Online', 'Shopping', 'India')
@section('title',"Exclusive " .ucfirst($search_query)." Coupons, Cashbacks, Deals & Offers" )

@section('content')
    <div class="top-pad"></div>
    <div class="background gray">
        <div class="container">
            {{-- Include Sidebar --}}
            @include('pages.search.searchSidebar')
            <div class="column-9">
                <div class="offer-wrapper">
                    <section class="search-offers">
                        <div class="search-offers-wrapper">
                            <div class="offers">
                                <div class="showing-offers pull-left">
                                    <p class="showing-offers-count-page">Showing <span class="ion-android-remove"></span><span class="ion-android-remove"></span> {{count($search_results)}} offers for '<strong>{{$search_query}}</strong>'</p>
                                </div>
                                <div class="filter pull-right">
                                    <div class="filter-select">
                                        <select id="sort">
                                            <option value="newest">Newest First</option>
                                            <option value="oldest">Oldest First</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                @if ($search_results)
                                    <ul class="offers-list-wrapper">
                                        @foreach($search_results as $i => $offer)
                                            <li class="offer-list-item">
                                                <div class="offer-amount">
                                                    @if ($offer->offer_cashback)
                                                        <h3 class="cashback-amount-text">{{$offer->offer_cashback}}%<br>OFF</h3>
                                                    @elseif($offer->offer_cashback_amount)
                                                        <h3 class="cashback-amount-text">Rs.{{$offer->offer_cashback_amount}}<br>OFF</h3>
                                                    @elseif(!is_null($offer->offer_coupon_code))
                                                        <h3 class="cashback-amount-text">{{$offer->offer_coupon_code}}</h3>
                                                    @endif
                                                    <img class="store-logo" src="//cdn.grabbthedeal.in/{{$singleStore[$i]->store_logo}}">
                                                </div>
                                                <div class="offer-desc">
                                                    <a href="{{secure_url('/offer-redirect',$offer->offer_id)}}" class="offer-title @if (is_null(Request::cookie('user_id'))) signin @endif">{{$offer->offer_name}}</a>
                                                    <div class="offer-desc-text less">@if (str_word_count($offer->offer_details) > 37) {!! join(" ",array_slice(explode(' ', $offer->offer_details),0,36)) !!} ... <a href="#" class="see-more-text pull-right">See More</a>@else {!! $offer->offer_details !!} @endif</div>
                                                    <div class="offer-desc-text more">{!! $offer->offer_details !!} <a href="#" class="see-more-text pull-right">See Less</a></div>                                                </div>
                                                <div class="offer-action">
                                                    <a class="button featured green outline">Featured</a>
                                                    <a href="{{secure_url('/offer-redirect',$offer->offer_id)}}" class="button gtd @if (is_null(Request::cookie('user_id'))) signin @endif">Grabb The Deal <span class="ion-android-arrow-forward pull-right"></span></a>
                                                </div>
                                                <div class="offer-footer">
                                                    <div class="content-block">
                                                        <p class="footer-small-text"><i class="ion-android-time"></i> posted {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $offer->created_at)->diffForHumans()}}</p>
                                                    </div>
                                                    <div class="content-block">
                                                        <p class="footer-small-text"><i class="ion-android-stopwatch"></i> expiry on {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$offer->offer_validity)->toFormattedDateString()}}</p>
                                                    </div>
                                                    <div class="content-block">
                                                        <a class="footer-small-text" data-tooltip="how-it-works">
                                                            <div class="tooltip-wrapper">
                                                                <ul class="tooltip-lists">
                                                                </ul>
                                                            </div>
                                                            <i class="ion-android-alert"></i> how it works</a>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @else
                                    <div class="no-offers">
                                        <h3 class="no-offers-text">No offers found for {{$search_query}}</h3>
                                    </div>
                                    @endif
                            </div>
                            <div class="clear"></div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection