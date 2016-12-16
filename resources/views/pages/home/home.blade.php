@extends('layouts.master')

@section('title', "Free Cashbacks, Upto 100% Cashbacks On All Leading Stores In India")

@section('content')
    {{--@parent--}}
    <div class="top-pad"></div>
    <div class="offers-slider">
        <div class="container">
            <div class="main-featured-wrapper">
                <div class="nav prev pull-left"><img src="//cdn.grabbthedeal.in/assets/img/sliders/machine/left-chevron.svg"></div>
                <div class="nav next pull-right"><img src="//cdn.grabbthedeal.in/assets/img/sliders/machine/right-chevron.svg"></div>
                <div class="main-featured owl-carousel owl-theme">
                    @for($i = 0; $i < count($sliders["main_featured"]); $i++)
                        <a href="{{route('offers',$sliders["main_featured"][$i]->slider_store)}}"><img class="" src="https://cdn.grabbthedeal.in/{{$sliders["main_featured"][$i]->slider_img}}" title="{{$sliders["main_featured"][$i]->slider_name}}" alt="{{$sliders["main_featured"][$i]->slider_name}}"></a>
                    @endfor
                </div>
            </div>

            @for($i = 0; $i < count($sliders["sub_featured"]); $i++)
                <div class="sub-featured @if($i == (count($sliders["sub_featured"]) - 1)) bottom @endif">
                    <a href="{{route('offers',$sliders["sub_featured"][$i]->slider_store)}}"><img class="slider-img" src="//cdn.grabbthedeal.in/{{$sliders["sub_featured"][$i]->slider_img}}" title="{{$sliders["sub_featured"][$i]->slider_name}}" alt="{{$sliders["sub_featured"][$i]->slider_name}}"></a>
                </div>
            @endfor
        </div>
    </div>

    @if (is_null(Request::cookie('user_id')))
    <div class="cta-hero top">
        <div class="container">
            <div class="cta-register">
                <h3>Get <span>Rs. 150</span> free with your first confirmed cashback !!</h3>
                <a href="#signup" class="button medium blue signup">Claim My Rs. 150 Now</a>
            </div>
        </div>
    </div>
    @endif

    {{--<div class="today-deals-wrapper background gray">--}}
        {{--<div class="container">--}}
            {{--<div class="today-deals">--}}
                {{--<h3 class="title">Today's Deals</h3>--}}
                {{--<div class="container">--}}
                    {{--<!-- Prev/Next Button -->--}}
                    {{--<div class="arrow pull-left left"><i class="ion-chevron-left"></i></div>--}}
                    {{--<div class="arrow pull-right right"><i class="ion-chevron-right"></i></div>--}}

                    {{--<ul id="today-deals-slider" class="owl-carousel owl-theme" data-click-source="deals-slider">--}}
                        {{--@for($i = 0; $i < count($today_deals); $i++)--}}
                            {{--<li class="today-deals-card">--}}
                                {{--<div class="card-image">--}}
                                    {{--<img class="deal-img" src="https://cdn.grabbthedeal.in/{{$today_deals[$i]["deal_img"]}}" title="{{$today_deals[$i]["deal_name"]}}" alt="{{$today_deals[$i]["deal_name"]}}">--}}
                                    {{--<div class="store-img">--}}
                                        {{--<img class="deal-store-img" src="//cdn.grabbthedeal.in/{{$today_deals[$i]["deal_store_logo"]}}" title="{{$today_deals[$i]["deal_store_name"]}}" alt="{{$today_deals[$i]["deal_store_name"]}}">--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="card-details">--}}
                                    {{--<a class="det-name" href="{{secure_url('/deal-redirect', $today_deals[$i]["deal_id"])}}" title="{{$today_deals[$i]["deal_name"]}}"><p class="deal-text">{{$today_deals[$i]["deal_name"]}}</p></a>--}}
                                    {{--<p class="det-stat"><span class="pres">Rs. {{$today_deals[$i]["deal_new_price"]}}</span><span class="past">Rs. {{$today_deals[$i]["deal_old_price"]}}</span><span class="disc">Flat {{$today_deals[$i]["deal_discount"]}}% off</span></p>--}}
                                {{--</div>--}}
                                {{--<a href="{{secure_url('/deal-redirect', $today_deals[$i]["deal_id"])}}" target="_blank" class="button blue @if (is_null(Request::cookie('user_id'))) signin @endif">UPTO @if ($today_deals[$i]["deal_cashback"]) {{$today_deals[$i]["deal_cashback"]}}% @else RS. {{$today_deals[$i]["deal_cashback_amount"]}}@endif IN CASHBACK</a>--}}
                            {{--</li>--}}
                        {{--@endfor--}}
                    {{--</ul>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
        {{--</div>--}}

    <div class="top-stores-card-wrapper">
        <div class="container">
            <h3 class="title">Top Stores</h3>
            @for($i = 0; $i < count($top_stores); $i++)
            <a href="{{route('offers',$top_stores[$i]->store_id)}}" class="top-stores-card">
                <div class="top-stores-logo">
                    <img class="stores-logo" src="//cdn.grabbthedeal.in/{{$top_stores[$i]->store_logo}}" alt="{{$top_stores[$i]->store_name}}">
                </div>
                <div class="top-stores-body">
                    <p class="top-stores-cb">Upto
                        @if(!empty($top_stores[$i]->store_cashback_amount))
                            Rs. {{$top_stores[$i]->store_cashback_amount}}
                        @else
                            {{$top_stores[$i]->store_cashback}}%
                        @endif
                            Cashback</p>
                </div>
                <div class="top-stores-det">
                    <p class="total-offers">{{$top_stores_offer_count[$i]}} @if ($top_stores_offer_count[$i] > 1) {{str_plural('Offer')}} @else Offer @endif Available</p>
                </div>
            </a>
            @endfor
        </div>
    </div>

    <div class="offers-card-wrapper">
        <div class="container">
            <h3 class="title">Hot Deals</h3>
            @foreach($offers as $key => $offer)
                <div class="column-4">
                    <div class="offers-card">
                        <div class="offers-card-denom">
                            @if($offer->offer_cashback)
                                <h3>{{$offer->offer_cashback}}% OFF</h3>
                            @elseif($offer->offer_cashback_amount)
                                <h3>Rs.{{$offer->offer_cashback_amount}} OFF</h3>
                            @elseif($offer->offer_coupon_code)
                                <h3>{{$offer->offer_coupon_code}}</h3>
                            @endif
                            <h3></h3>
                        </div>
                        <div class="offers-card-img pull-left">
                            <img src="//cdn.grabbthedeal.in/{{$offersStoreImg[$key]['store_img']}}">
                        </div>
                        <div class="offers-card-extras pull-right">
                            <p class="offer-featured button green outline pull-right">Featured</p>
                        </div>
                        <div class="clearfix"></div>
                        <div class="offers-card-details">
                            <a href="{{route('offers',['stores' => $storeOffer[$key]['store_id']])}}" class="offer-name">{{$offer->offer_name}}</a>
                        </div>
                        <div class="offers-card-footer">
                            @if($offer->offer_cashback)
                                <p class="offer-cb-rate pull-left">Upto {{$offer->offer_cashback}}% Cashback</p>
                            @elseif($offer->offer_cashback_amount)
                                <p class="offer-cb-rate pull-left">Upto Rs.{{$offer->offer_cashback_amount}} Cashback</p>
                            @endif
                            <a href="{{route('offers',['stores' => $storeOffer[$key]['store_id']])}}" class="see-more pull-right">See all {{$storeOffer[$key]['count']}} offers</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="subscribe-wrapper">
        <div class="container">
            <div class="subscribe">
                <div class="sub-img">
                    <img src="//cdn.grabbthedeal.in/assets/img/mailbox.svg">
                </div>
                <div class="sub-text">
                    <h2>Latest deals and cashback offers straight to your inbox</h2>
                </div>
                <div class="sub-form">
                    <form action="//grabbthedeal.us14.list-manage.com/subscribe/post?u=3659ab6ce5796e871477790f2&amp;id=2729b5e6e7" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" novalidate>
                        <input class="sub-input" type="email" name="EMAIL" id="subscribe-email" placeholder="Enter your e-mail address" required>
                        <input class="sub-btn" type="submit" value="Send Me My Deals">
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endsection