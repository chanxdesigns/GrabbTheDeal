@extends('layouts.sidebar')
@section('sidebar')
    @if(count($categories))
    <p class="card-header">Categories</p>
    <div class="card-wrapper">
        <div class="sidebar-gen">
            <div class="sidebar-categories">
                <div class="filter-input-icon-wrapper">
                    <input type="text" class="filter-input" placeholder="Filter Categories">
                </div>
                <ul class="cat-filter-wrapper">
                    @for($i = 0; $i < count($categories); $i++ )
                        <li class="cat-filter">
                        <input type="checkbox" value="{{$categories[$i]['category_id']}}" id="{{$categories[$i]['category_id']}}">
                        <label for="{{$categories[$i]['category_id']}}">{{$categories[$i]['category_name']}}</label>
                        @endfor
                </ul>
            </div>
        </div>
    </div>
    @endif

    @if(count($stores))
    <p class="card-header">Stores</p>
    <div class="card-wrapper">
        <div class="sidebar-gen">
            <div class="sidebar-categories">
                <div class="filter-input-icon-wrapper">
                    <input type="text" class="filter-input" placeholder="Filter Categories">
                </div>
                <ul class="cat-filter-wrapper">
                    @for($i = 0; $i < count($stores); $i++ )
                        <li class="stores-filter">
                            <input type="checkbox" value="{{$stores[$i]['store_id']}}" id="{{$stores[$i]['store_id']}}">
                            <label for="{{$stores[$i]['store_id']}}">{{$stores[$i]['store_name']}}</label>
                    @endfor
                </ul>
            </div>
        </div>
    </div>
    @endif

    @endsection