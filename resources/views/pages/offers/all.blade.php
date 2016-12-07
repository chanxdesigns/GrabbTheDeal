{{-----------------------------------------
    All Offers Page
    Display All Offers
    Route - www.grabbthedeal.in/store/{store}
-----------------------------------------}}
@extends('layouts.master')
@section('title','All Offers')
@section('content')
    <div class="background">
        <div class="top-pad"></div>
        <div class="sub-header-image">
            <div class="sub-header-text">
                <h3>{{strtoupper($store->store_name)}}</h3>
                <p>Upto <span>5%</span> Cashback Rewards from Grabb The Deal</p>
            </div>
        </div>
        <div class="container">
            {{-- Include Sidebar From The Sidebar Partial --}}
            @include('pages.offers.offerSidebar')

            <div class="column-9">
                <div class="offer-wrapper">
                    <div class="intro">
                        <h3 class="intro-text">Shop and Save more on {{$store->store_name}} offers</h3>
                        <a class="link button blue pull-right" href="/how-it-works">HOW TO GET CASHBACKS? <i class="ion-ios-play-outline"></i> </a>
                        <p class="sub-intro"><strong><span>{{$offers_count}}</span> Offers Available</strong> - Upto <strong><span>20%</span></strong> Cashback from Grabb The Deal</p>
                    </div>
                    <section class="brand-offers">
                        @if($offers->count())
                            @foreach($offers as $offer)
                                <div class="brand-offers-wrapper featured">
                                    {{-- Display The Offer Amount --}}
                                    <div class="offer-amount pull-left">
                                        <h1>{{$offer->offer_cashback}}%</h1>
                                        <p>- CASHBACK -</p>
                                        <img src="{{asset($store->store_logo)}}"
                                             alt="{{$store->store_name}} store logo">
                                    </div>

                                    {{-- Offer Details and Featured Tag for Featured Offers --}}
                                    <div class="offer-desc pull-left" id="{{$offer->offer_id}}">
                                        <div class="offer-desc-body">
                                            <p class="offer-store-name">{{$store->store_name}}</p>
                                            {{--
                                            <div class="verified">
                                                <span>@if($offer->offer_verified == 'true')
                                                        Verified
                                                    @endif
                                                </span>
                                                <span><i class="ion-ios-star"></i> Featured</span>
                                            </div>
                                            --}}
                                            <a href="{{$offer->offer_link}}" class="offer-name"
                                               target="_blank">{{$offer->offer_name}}</a>
                                            <p class="cashback">+ Flat {{$offer->offer_cashback}}% Cashback from Grabb
                                                The Deal</p>
                                            <p>{{$offer->offer_details}}</p>
                                        </div>

                                        <div class="offer-desc-footer">
                                            {{--
                                            <div class="icons">
                                                <span class="ion-ios-heart-outline"></span>
                                            </div>
                                            --}}
                                            <span class="timer">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $offer->created_at)->diffForHumans()}}</span>
                                        </div>
                                    </div>

                                    <div class="offer-goto-button pull-right">
                                        <a href="{{$offer->offer_link}}"
                                           class="@if (empty(Session::get('user_id'))) signin @endif button outline pink pull-right">Grabb
                                            The Deal</a>
                                    </div>

                                    <div class="clear"></div>
                                </div>
                            @endforeach
                        @else
                            <div class="error">
                                <h3 class="title">OOPS !!</h3>
                                <p class="text">No Offers Founds</p>
                            </div>
                        @endif
                    </section>
                    {{-- More Info Section About The Selected Brand --}}
                    <section class="about-brand">
                        <h3>About {{$store->store_name}}</h3>
                        <p>{{$store->store_details}}</p>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection