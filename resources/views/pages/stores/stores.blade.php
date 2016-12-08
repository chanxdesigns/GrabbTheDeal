{{-----------------------------------------
    Category Page
    Displays All Available Categories
    Route - www.grabbthedeal.in/category/
-----------------------------------------}}

@extends('layouts.master')
@section('title', 'All Stores')

@section('content')
    <div class="top-pad"></div>

    <!-- Popup stores navigation -->
    <div class="popup-store-wrapper">
        <div class="popup-store-backdrop">
            <div class="popup-store-nav-body">
                <i class="ion-android-close close pull-right"></i>
                <div class="popup-store-logo-wrapper">
                    <img class="popup-store-logo" src="">
                </div>
                <div class="popup-store-cashback-rate-wrapper">
                    <h3 class="popup-store-cashback-rate"></h3>
                </div>
                <p class="popup-store-offers"></p>
                <div class="popup-store-buttons">
                        <a href="" id="view-offers" target="_blank" class="button primary medium">View Offers</a>
                        <a href="" id="visit-store" target="_blank" class="button blue medium no-margin">Visit Store</a>
                </div>
            </div>
        </div>
    </div>

    <div class="store-header">
        <div class="container">
            <h1>All Stores & Categories To Shop From</h1>
        </div>
    </div>

    <div class="background gray">
        <div class="container">
            <!--
            <a href="">Home</a> > <a href="">Stores</a>
            -->
                {{-- Categories Sidebar Partial --}}
                @include('pages.stores.storesSidebar')
                    <section class="store-wrapper pull-right">
                        <div class="store-top-offers">
                            <p class="title">All Stores</p>
                        </div>

                        <div class="stores-wrapper">
                            <ul>
                                @foreach($stores as $store)
                                    <li class="stores-list" id="{{$store['store_id']}}">
                                        <a class="stores-card" href="/offers/{{$store['store_id']}}">
                                            <div class="store-card-header">
                                                <img src="//cdn.grabbthedeal.in/{{$store['store_logo']}}" class="logo" title="{{$store['store_name']}}" alt="{{$store['store_name']}}">
                                            </div>
                                            <div class="store-card-details">
                                                <input type="hidden" id="hid-count" value="{{$store['offers_count']}}">
                                                <input type="hidden" id="hid-cashback" value="@if ($store['store_cashback']){{$store['store_cashback']}}% @else Rs. {{$store['store_cashback_amount']}} @endif">
                                                <p>@if ($store['offers_count']) {{$store['offers_count']}} @else No @endif
                                                    @if (!is_null($store['offers_count']) && $store['offers_count'] > 1) Offers @else Offer @endif Available</p>
                                            </div>
                                            <div class="store-card-footer">
                                                <p class="store-footer-text">Upto @if ($store['store_cashback']){{$store['store_cashback']}}% @else Rs. {{$store['store_cashback_amount']}} @endif Cashback</p>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="bottom-about-us-excerpt">
                            <h3>Get Upto 50% Cashbacks, Exciting Deals & Exclusive Offers only on Grabb The Deal</h3>
                            <p>At Grabb The Deal, our main mission is to help users <strong>"Shop More & Save More"</strong> and to achieve this we provide our users with exclusive deals, offers and huge cashbacks to help them do more shopping.</p>
                            <h3>Why shop through Grabb The Deal?</h3>
                            <p>Shopping through Grabb The Deal gives you extra cashback over and above the discount offered by the store. Our team collects and curates the best deals and offers virtually from every store in the country to help you find it easier.</p>
                        </div>

                    </section>
        </div>
    </div>
    @endsection
