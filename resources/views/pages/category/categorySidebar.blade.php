{{-- Sidebar Start --}}
@extends('layouts.sidebar')
@section('sidebar')
    {{-- Sub-Categories Available for the particular Parent category --}}
    @if(!empty($offers))
    <h3 class="card-header">Sub Categories</h3>
    <div class="card-wrapper">
        <div class="sidebar-gen">
            <div class="sidebar-categories">
                <div class="filter-input-icon-wrapper">
                    <input type="text" class="filter-input" placeholder="Filter Categories">
                </div>
                <ul class="cat-filter-wrapper">
                    @foreach($sub_categories as $sub_category)
                        <li class="cat-filter">
                            <input id="{{$sub_category['category_id']}}" type="checkbox" value="{{$sub_category['category_name']}}">
                            <label for="{{$sub_category['category_id']}}">{{ucwords($sub_category['category_name'])}}</label>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif
    {{-- Available stores for the particular category --}}
    <h3 class="card-header">Stores</h3>
    <div class="card-wrapper">
        <div class="sidebar-gen">
            <div class="sidebar-categories">
                <div class="filter-input-icon-wrapper">
                    <input type="text" class="filter-input" placeholder="Filter Categories">
                </div>
                <ul class="cat-filter-wrapper">
                    @foreach($stores as $store)
                        <li class="stores-filter">
                            <input id="{{$store['store_id']}}" type="checkbox" value="{{$store['store_name']}}">
                            <label for="{{$store['store_id']}}">{{ucwords($store['store_name'])}}</label>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection