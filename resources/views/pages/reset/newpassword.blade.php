@extends('layouts.master')
@section('title', 'Change New Password')

@section('content')
    <div class="top-pad"></div>
    <div class="container">
        <div class="password-reset-form-wrapper">
            <h3 class="password-reset-header">Reset Password</h3>
            <form class="password-reset-form" id="reset-new-password" method="post" action="{{secure_url('/password/reset/new')}}">
                {{ csrf_field() }}
                <input type="hidden" name="user_id" id="user_id" value="{{$user_id}}" >
                <div class="form-group">
                    <label for="new-password">New Password</label>
                    <input type="password" name="new-password" id="new-password" required>
                </div>
                <div class="form-group">
                    <label for="new-password-conf">Confirm Password</label>
                    <input type="password" name="new-password-conf" id="new-password-conf" required>
                    <p class="small failed" style="text-align: center"></p>
                </div>
                <input type="submit" value="Change password">
            </form>
            <p class="password-reset-message"></p>
        </div>
    </div>
    @endsection