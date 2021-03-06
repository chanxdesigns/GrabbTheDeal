{{-----------------------------------------
    Offers Page
    Display Stores Specific Offers
    Route - www.grabbthedeal.in/store/{store}
-----------------------------------------}}
@extends('layouts.master')
{{-- Meta Information --}}
@section('description')
    Get {{$store->store_name}} Offers, Deals, Coupons & Cashbacks Upto @if($store->store_cashback) {{$store->store_cashback}}% @else Rs. {{$store->store_cashback_amount}}@endif From Grabb The Deal.
@endsection
@section('keywords', $store->store_name.', Offers, Deals, Coupons, Cashbacks, Online Shopping, India, 100% Cashback')
@section('title')
    {{$store->store_name}} Offers, Coupons & Cashbacks. Upto @if($store->store_cashback) {{$store->store_cashback}}% @else Rs. {{$store->store_cashback_amount}}@endif in Cashback From
    @endsection
@section('page-image', 'https://cdn.grabbthedeal.in/'.$store->stores_img)

@section('content')
    <div class="background gray">
        <div class="top-pad"></div>
        <div class="top-panel">
            <div class="top-panel-overlay">
                <input type="hidden" value="{{$store->stores_img}}">
                <div class="container">
                    <div class="left-tab pull-left">
                        <div class="main-image-wrapper">
                            <img class="main-image" src="//cdn.grabbthedeal.in/{{$store->store_logo}}">
                        </div>
                        <p class="subtitle-text">{{$offers_count}} offers available</p>
                        <a href="{{secure_url('/store-redirect',$store->store_id)}}" title="Shop from {{strtoupper($store->store_name)}} now" class="button primary outline">SHOP NOW</a>
                    </div>
                    <div class="center-tab pull-left">
                        <h3 class="header-text">{{$store->store_name}} Coupons, Deals and Offers</h3>
                        <div class="body-text less">@if (str_word_count($store->store_details) > 50) {!! join(" ",array_slice(explode(' ', $store->store_details),0,49)) !!} ... <a href="#" class="see-more-text pull-right">See More</a>@else {!! $store->store_details !!} @endif</div>
                        <div class="body-text more">{!! $store->store_details !!} <a href="#" class="see-more-text pull-right">See Less</a></div>
                    </div>
                    <div class="right-tab pull-right">
                        <ul class="breadcrumb-panel pull-right" itemscope="" itemtype="https://schema.org/BreadcrumbList">
                            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breadcrumb-link"><a itemprop="name" href="{{secure_url('/')}}">Home</a></li>
                            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breadcrumb-link"><a itemprop="name" href="{{route('stores')}}">Stores</a></li>
                            <li class="breadcrumb-link">{{$store->store_name}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            {{-- Include Sidebar From The Sidebar Partial --}}
            @include('pages.offers.offerSidebar')
                <div class="offers pull-right">
                    {{--<div class="selected-offer">--}}
                        {{--<img src="//cdn.grabbthedeal.in/assets/img/categories/food-beverage-rect.jpg')}}">--}}
                    {{--</div>--}}
                    <div class="showing-offers pull-left">
                        <p class="showing-offers-count-page">Showing <span class="ion-android-remove"></span><span class="ion-android-remove"></span> {{count($offers)}} of {{$offers_count}} offers</p>
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
                    @if (count($offers))
                        <ul class="offers-list-wrapper">
                            @foreach($offers as $offer)
                                <li class="offer-list-item">
                                    <div class="offer-amount">
                                        @if ($offer->offer_cashback)
                                            <h3 class="cashback-amount-text">{{$offer->offer_cashback}}%<br>OFF</h3>
                                        @elseif($offer->offer_cashback_amount)
                                            <h3 class="cashback-amount-text">Rs.{{$offer->offer_cashback_amount}}<br>OFF</h3>
                                        @elseif(!is_null($offer->offer_coupon_code))
                                            <h3 class="cashback-amount-text">{{$offer->offer_coupon_code}}</h3>
                                        @endif
                                        <img class="store-logo" src="//cdn.grabbthedeal.in/{{$store->store_logo}}">
                                    </div>
                                    <div class="offer-desc">
                                        <a href="{{secure_url('/offer-redirect',$offer->offer_id)}}" class="offer-title @if (is_null(Request::cookie('user_id'))) signin @endif">{{$offer->offer_name}}</a>
                                        <div class="offer-desc-text less">@if (str_word_count($offer->offer_details) > 37) {!! join(" ",array_slice(explode(' ', $offer->offer_details),0,36)) !!} ... <a href="#" class="see-more-text pull-right">See More</a>@else {!! $offer->offer_details !!} @endif</div>
                                        <div class="offer-desc-text more">{!! $offer->offer_details !!} <a href="#" class="see-more-text pull-right">See Less</a></div>
                                    </div>
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
                            <h3 class="no-offers-text">No offers found for <span class="imp">{{$store->store_name}}</span></h3>
                        </div>
                    @endif
                    <div class="store-footer-details">
                        <h3>About {{$store->store_name}}</h3>
                        <p>{!! $store->store_details !!}</p>
                    </div>
                </div>
            </div>
        </div>
@endsection