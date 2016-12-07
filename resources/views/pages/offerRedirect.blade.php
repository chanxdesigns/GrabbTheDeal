@extends('layouts.master')
@section('title', 'Redirecting to Offer Page')
@section('content')
    <div class="top-pad"></div>
    <div class="container">
        <div class="offer-redirect-wrapper">
            <div class="redirect-header">
                <img class="header-img pull-left" src="//cdn.grabbthedeal.in/{{$store->store_logo}}">
                <p class="header-text pull-right">{{$offer->offer_name}}</p>
            </div>
            <div class="redirect-body">
                <p class="redirect-body-title">PLEASE WAIT</p>
                <h3 class="redirect-text"><span class="span-text">@if (Request::cookie('user_name')) {{explode(' ',Request::cookie('user_name'))[0]}} @else Hello Stranger @endif</span>, You are being redirected to {{$store->store_name}}</h3>
                <img class="loading-spinner" src="//cdn.grabbthedeal.in/assets/img/ellipsis.gif">
                <h3 class="redirect-text">Shop and get <span class="span-text">upto {{$store->store_cashback}}%</span> cashback</h3>
                <p class="redirect-sub-text">Happy Shopping!</p>
                <p class="redirect-small-text"><span class="warning">*</span> Complete your shopping in this session and don't visit other coupon sites.</p>
            </div>
            <input type="hidden" id="redirect-offer-id" value="{{$offer->offer_id}}">
        </div>
    </div>
    @endsection