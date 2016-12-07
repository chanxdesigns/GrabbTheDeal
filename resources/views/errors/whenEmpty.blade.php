{{--
    View Partial for The Empty Offer
    Displays Only On Empty Offers
 --}}
@extends('layouts.master')
@section('content')
    <div class="top-pad"></div>
    <div class="container">
        <div class="empty-offers">
            <h3>{{$empty_msg}}</h3>
        </div>
    </div>
    @endsection

