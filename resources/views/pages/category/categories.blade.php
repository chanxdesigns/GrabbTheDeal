@extends('layouts.master')

{{-- Heading Content --}}
@if (empty($offers))
    @section('description', 'Online Shopping Coupons & Cashbacks From Multiple Categories')
    @section('keywords', 'Travel, Electronics & Gadgets, Home Appliances, Home & Decor, Gift Items, Fashion & Clothing, Mobiles, Computers & Laptops, Beauty, Food & Drink, Recharge & Bill Payments, Holidays Coupons, Deals, Offers, Cashback, 300+ Stores')
    @section('title', 'Listing All Categories')
    @section('page-image', 'https://cdn.grabbthedeal.in/'.$category[0]['category_img'])
@else
    @section('description')
        {{$category[0]['category_name']}} Offers, Coupons & Cashbacks From
        @foreach ($stores as $store)
            {{$store['store_name']}},
        @endforeach
    @endsection
    @section('keywords', $category[0]['category_name'].' Online Shopping', 'Deals', 'Offers', 'Cashback', 'Coupons')
    @section('title', $category[0]['category_name'].' Deals, Offers, Coupons & Cashbacks')
@endif

@section('content')
    <div class="background gray">
    <div class="top-pad"></div>
    <div class="container">
        @include('pages.category.categorySidebar')
            {{-- If Offers Empty -- Show Categories List --}}
            @if (empty($offers))
                <section class="categories-lists-wrapper pull-right">
                    <div class="intro">
                        <p>Showing {{count($categories)}} available categories</p>
                    </div>
                    @foreach($categories as $category)
                        <a href="{{route('offersByCategories',["category" => $category['category_id']])}}" title="{{$category['category_name']}}">
                            <div class="categories-list">
                                <img class="category-img" src="//cdn.grabbthedeal.in/{{$category['category_img']}}">
                                <div class="category-name">
                                    <h3>{{strtoupper($category['category_name'])}}</h3>
                                </div>
                                <div class="category-details">
                                    <h3>{{$category['offers_count']}} offers available</h3>
                                    {{--<p>Upto <strong>{{$category['max_cashback']}}%</strong> GTD Cashback</p>--}}
                                </div>
                            </div>
                        </a>
                    @endforeach
                    <div class="clearfix"></div>
                </section>
                {{-- If Offers Present  -- Show Offers Lists --}}
                @else
                <section class="category-wrapper pull-right">
                    <div class="category-header">
                        <div class="category-img-wrapper">
                            <img class="category-img" src="//cdn.grabbthedeal.in/{{$category_details->category_img_big}}">
                        </div>
                        <div class="category-details-wrapper">
                            <h3 class="header-text">{{$category_details->category_name}}</h3>
                            <p class="header-sub-text">Top {{$category_details->category_name}} Offers, Coupons, Deals & Cashback</p>
                        </div>
                    </div>

                    <div class="offers">
                        <div class="showing-offers pull-left">
                            <p class="showing-offers-count-page">Showing <span class="ion-android-remove"></span><span class="ion-android-remove"></span> {{count($offers)}} offers</p>
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
                        <div class="offer-lists-wrapper">
                            @if (count($offers))
                                <ul class="offers-list-wrapper">
                                    @foreach($offers as $i => $offer)
                                        <li class="offer-list-item">
                                            <div class="offer-amount">
                                                @if ($offer->offer_cashback)
                                                    <h3 class="cashback-amount-text">{{$offer->offer_cashback}}%<br>OFF</h3>
                                                @elseif($offer->offer_cashback_amount)
                                                    <h3 class="cashback-amount-text">Rs.{{$offer->offer_cashback_amount}}<br>OFF</h3>
                                                @elseif(!is_null($offer->offer_coupon_code))
                                                    <h3 class="cashback-amount-text">{{$offer->offer_coupon_code}}</h3>
                                                @endif
                                                    <img class="store-logo" src="//cdn.grabbthedeal.in/{{$offer_stores[$i]->store_logo}}">
                                            </div>
                                            <div class="offer-desc">
                                                <a href="{{secure_url('/offer-redirect',$offer->offer_id)}}" class="offer-title @if (is_null(Request::cookie('user_id'))) signin @endif">{{$offer->offer_name}}</a>
                                                <div class="offer-desc-text less">@if (str_word_count($offer->offer_details) > 37) {!! join(" ",array_slice(explode(' ', $offer->offer_details),0,36)) !!} ... <a href="#" class="see-more-text pull-right">See More</a>@else {!! $offer->offer_details !!} @endif</div>
                                                <div class="offer-desc-text more">{!! $offer->offer_details !!} <a href="#" class="see-more-text pull-right">See Less</a></div>                                            </div>
                                            <div class="offer-action">
                                                <a class="button featured green outline">Featured</a>
                                                <a href="{{secure_url('/offer-redirect',[str_slug($offer->offer_name,'-'),$offer->offer_id])}}" class="button gtd @if (is_null(Request::cookie('user_id'))) signin @endif">Grabb The Deal <span class="ion-android-arrow-forward pull-right"></span></a>
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
                                {{--<div class="no-offers">--}}
                                    {{--<h3 class="no-offers-text">No offers found for <span class="imp">{{$store->store_name}}</span></h3>--}}
                                {{--</div>--}}
                            @endif
                        </div>
                    </div>
                    </section>
            @endif
    </div>
    </div>
    @endsection