@extends('layouts.master')
@section('title', 'Oops !! Page Not Found')
@section('content')
    <div class="top-pad"></div>
    <div class="container">
        <div class="error-page">
            <img class="error-img" src="//cdn.grabbthedeal.in/assets/img/404.svg">
            <h3 class="error-title">404 PAGE NOT FOUND</h3>
            <p class="error-text">Looks like you have landed on the wrong page. You may wanna -</p>
            <a class="button medium blue" href="{{secure_url('/')}}">GO HOME</a>
        </div>
    </div>
    @endsection