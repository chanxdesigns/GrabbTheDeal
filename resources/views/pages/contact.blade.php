@extends('layouts.master')
@section('title', 'Contact Us')
@section('content')
    <div class="top-pad"></div>
    <div class="container">
        <div class="column-3">
            @include('pages.contactSidebar')
        </div>
        <div class="column-9">
            <div class="contact-wrapper">
                <h3 class="title">Contact Us</h3>
                <p class="sub-title">
                    <strong>Need Help! We are here to help you.</strong><br>
                </p>
                <form class="contact-form" id="contact-form" method="post" action="{{secure_url('/contact/send')}}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="label">Name</div>
                        <input type="text" id="contact-name" name="name" placeholder="Enter your name" required>
                    </div>
                    <div class="form-group">
                        <div class="label">E-mail</div>
                        <input type="email" id="contact-mail" name="email" placeholder="Enter your e-mail address" required>
                    </div>
                    <div class="form-group">
                        <div class="label">Subject</div>
                        <input type="text" id="contact-subject" name="subject" placeholder="Your subject line" required>
                    </div>
                    <div class="form-group">
                        <div class="msg-input-holder">
                            <div class="label">Message</div>
                            <textarea id="contact-msg" name="message" rows="6" placeholder="Your message"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="label"></div>
                        <input type="submit" id="contact-submit">
                        <img class="loader2" src="//cdn.grabbthedeal.in/assets/img/loader-2.gif">
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection