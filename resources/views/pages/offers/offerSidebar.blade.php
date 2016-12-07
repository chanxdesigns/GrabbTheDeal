{{-----------------------------------------
    Offers Sidebar
    The Sidebar For Offers Page
    -- Template Partial --
-----------------------------------------}}

{{-- Sidebar Start --}}
@extends('layouts.sidebar')
@section('sidebar')
    {{-- Categories available for the particular store --}}
    @if (count($offer_categories) > 0)
    <p class="card-header">Categories</p>
    <div class="card-wrapper">
        <div class="sidebar-gen">
            <div class="sidebar-categories">
                <div class="filter-input-icon-wrapper">
                    <input type="text" class="filter-input" placeholder="Filter Categories">
                </div>
                <ul class="cat-filter-wrapper">
                    @for($i = 0; $i < count($offer_categories); $i++)
                        <li class="cat-filter">
                            <input id="{{$offer_categories[$i]['category_id']}}" type="checkbox" value="{{$offer_categories[$i]['category_name']}}">
                            <label for="{{$offer_categories[$i]['category_id']}}">{{ucwords($offer_categories[$i]['category_name'])}}</label>
                        </li>
                    @endfor
                </ul>
            </div>
        </div>
    </div>
    @endif
    @endsection


