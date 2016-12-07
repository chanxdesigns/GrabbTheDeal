{{-----------------------------------------
    Offers Sidebar
    The Sidebar For Offers Page
    Route - www.grabbthedeal.in/store/{brand}
-----------------------------------------}}

@extends('layouts.sidebar')
@section('sidebar')
    {{-- Categories List --}}
    <p class="card-header">Categories</p>
    <div class="card-wrapper">
            <div class="sidebar-categories">
                <div class="filter-input-icon-wrapper">
                    <input type="text" class="filter-input" placeholder="Filter Categories">
                </div>
                <ul class="cat-filter-wrapper">
                    @for($i = 0; $i < count($categories); $i++)
                        <li class="cat-filter">
                            <input id="{{$categories[$i]['category_id']}}" type="checkbox" value="{{$categories[$i]['category_name']}}">
                            <label for="{{$categories[$i]['category_id']}}">{{ucwords($categories[$i]['category_name'])}}</label>
                        </li>
                    @endfor
                </ul>
            </div>
    </div>
    @endsection