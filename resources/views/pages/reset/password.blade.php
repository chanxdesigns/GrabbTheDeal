@extends('layouts.master')
@section('title', 'Reset Password')

@section('content')
    <div class="top-pad"></div>
    <div class="container">
        <div class="password-reset-form-wrapper">
            <h3 class="password-reset-header">Reset Password</h3>
            <form class="password-reset-form" id="request-reset-password" method="post" action="{{secure_url('/password/reset/request')}}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="password-reset-email">E-mail id</label>
                    <input type="email" name="password-reset-email" id="password-reset-email">
                    <p class="small failed" style="text-align: center"></p>
                </div>
                <input type="submit" value="Reset my password">
            </form>
            <p class="password-reset-message"></p>
        </div>
    </div>
    @endsection