<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta name="charset" content="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Grabb The Deal provides upto 80% cashbacks on all online shopping from leading retailers in India.">
    <meta name="keywords" content="Free Cashbacks, 100% Cashbacks, Refunds, Online Shopping, India, Jabong, Amazon, Flipkart, Myntra, Koovs, Snapdeal, Junglee, Shopclues, Zovi, Voonik, Pepperfry, Happily Unmarried, Freecultr, Fashionandyou, Ebay">
    <meta name="token" content="{{ csrf_token() }}">
    <meta name="author" content="Chanx Singha <chandra.kumar@grabbthedeal.in">
    <title>@yield('title') - Grabb The Deal</title>
    <!-- Facebook OG tags -->
    <meta property="og:url" content="https://www.grabbthedeal.in">
    <meta property="og:description" content="Grabb The Deal provides upto 80% cashbacks on all online shopping from leading retailers in India.">
    <meta property="og:title" content="@yield('title')">

    <!-- CSS and JavaScripts -->
    <link href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="//cdn.grabbthedeal.in/assets/css/grid.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.grabbthedeal.in/assets/css/perfect-scrollbar.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.grabbthedeal.in/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.grabbthedeal.in/assets/css/owl.theme.min.css">
    {{--<link rel="stylesheet" type="text/css" href="//cdn.grabbthedeal.in/assets/css/styles.min.css">--}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/styles.css')}}">

    <!-- Google Analytics -->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-85063482-1', 'auto');
        ga('send', 'pageview');

    </script>

    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window,document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '652112534926979');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1"
             src="https://www.facebook.com/tr?id=652112534926979&ev=PageView
&noscript=1"/>
    </noscript>
    <!-- End Facebook Pixel Code -->
</head>
<body class="">

<div class="header">
    {{-- Header --}}
    <div class="top-header">
        <div class="container">
            <div class="left-content pull-left"></div>
            <div class="right-content pull-right">
                <div class="utility-bar">
                    <ul>
                        <li class="utility-link"><a href="{{secure_url('/contact')}}">Help</a></li>
                        <li class="utility-link"><a href="{{secure_url('/faq')}}">FAQs</a></li>
                        <li class="utility-link"><a href="{{secure_url('/how-it-works')}}">How It Works</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <header>
        <div class="container">
            <div class="logo pull-left">
                <a href="/"><img class="logo-img" src="//cdn.grabbthedeal.in/assets/img/gtd-logo.png"> </a>
            </div>
            <nav class="main-menu pull-left">
                <ul class="main-menu-link-wrapper">
                    <li class="main-menu-lists">
                        <a class="main-menu-link with-dd" href="#">Store deals <i class="ion-ios-arrow-down"></i></a><ul class="sub-menu">
                            <li class="sub-menu-lists">
                                @for($i = 0; $i < count($top_stores); $i++)
                                <a href="{{route('offers',$top_stores[$i]->store_id)}}" id="{{$top_stores[$i]->store_id}}" class="sub-menu-link">{{$top_stores[$i]->store_name}}</a>
                                @endfor
                                <a href="{{secure_url('/stores')}}" class="sub-menu-link last">More Stores <i class="ion-android-arrow-forward"></i></a>
                            </li>
                        </ul></li>
                    <li class="main-menu-lists">
                        <a class="main-menu-link with-dd" href="#">Category deals <i class="ion-ios-arrow-down"></i></a><ul class="sub-menu">
                            <li class="sub-menu-lists">
                                @for($i = 0; $i < count($top_categories); $i++)
                                <a href="{{route('offersByCategories', $top_categories[$i]->category_id)}}" id="{{$top_categories[$i]->category_id}}" class="sub-menu-link">{{$top_categories[$i]->category_name}}</a>
                                @endfor
                                <a href="{{secure_url('/categories')}}" class="sub-menu-link last">More Categories <i class="ion-android-arrow-forward"></i></a>
                            </li>
                        </ul></li>
                </ul>
            </nav>
            <div class="header-search pull-left">
                <form id="header-search-form" action="{{secure_url('/search')}}" method="get">
                    <div class="form-group">
                        <input class="text" id="search" name="q" placeholder="Search for deals, offers .etc">
                        <input type="submit" class="hidden">
                        <div class="form-icon"><i class="ion-android-search search-icon"></i></div>
                    </div>
                </form>
            </div>
            <div class="authentication pull-right">
                @if (Request::cookie('user_name') && Request::cookie('email') && Request::cookie('user_id'))
                    <ul class="user-menu-wrapper">
                        <li class="user-menu-lists">
                            <a class="user-menu-link">Hello {{explode(' ',Request::cookie('user_name'))[0]}} <i class="dd ion-android-arrow-dropdown"></i></a>
                            <ul class="user-sub-menu">
                                <li>
                                    <a class="user-sub-menu-link" href="{{route('myaccount',Request::cookie('user_id'))}}">View dashboard</a>
                                </li>
                                <li>
                                    <a class="user-sub-menu-link" href="{{route('logout')}}">Log out</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @else
                    <button class="button blue signin">Log In</button>
                @endif
            </div>
        </div>
    </header>
</div>

{{--------------------------------------------
 * Login Partial
 * Grabb The Deal/Login
 ****---------------------------------------}}

@if (is_null(Request::cookie('user_id')))
@include('pages.login.loginPartial')
@endif

{{--------------------------------------------
 * Register Partial
 * Grabb The Deal/Login
 ****---------------------------------------}}
@if (is_null(Request::cookie('user_id')))
@include('pages.register.registerPartial')
@endif


{{-- Body Contents --}}

@yield('content')

{{-- Body Contents --}}

<footer>
    <div class="main-footer">
        <div class="container">
            <div class="column-2">
                <div class="footer-nav">
                    <h3 class="footer-title">Navigation</h3>
                    <ul>
                        <li><a href="{{route('stores')}}">Stores</a></li>
                        <li><a href="{{route('categories')}}">Categories</a></li>
                        <li><a href="{{secure_url('/')}}">Home</a></li>
                        <li><a href="{{secure_url('/about')}}">About</a></li>
                        <li><a href="{{secure_url('/contact')}}">Contact Us</a>
                    </ul>
                </div>
            </div>
            <div class="column-2">
                <div class="footer-nav">
                    <h3 class="footer-title">Support</h3>
                    <ul>
                        <li><a href="{{secure_url('/faq')}}">Help & FAQs</a></li>
                        <li><a href="{{secure_url('/how-it-works')}}">How It Works</a></li>
                    </ul>
                </div>
            </div>
            <div class="column-2">
                <div class="footer-nav">
                    <h3 class="footer-title">Legal</h3>
                    <ul>
                        <li><a href="{{secure_url('/privacy-policy')}}">Privacy Policy</a></li>
                        <li><a href="{{secure_url('/terms-conditions')}}">Terms & Conditions</a></li>
                    </ul>
                </div>
                <div class="footer-nav">
                    <h3 class="footer-title">Shop Securely</h3>
                    <img src="{{asset('assets/img/comodo_secure_seal_100x85_transp.png')}}" style="margin: -20px 0 0 0;">
                </div>
            </div>
            <div class="column-2">
                <div class="footer-nav">
                    <h3 class="footer-title">We are present @:</h3>
                    <ul class="social">
                        <li><a href="http://www.facebook.com/grabbthedeal?ref=site" target="_blank"><i class="ion-social-facebook"></i></a></li>
                        <li><a href="http://www.twitter.com/grabbthedeal?ref=site" target="_blank"><i class="ion-social-twitter"></i></a></li>
                        <li><a href="http://www.instagram.com/grabbthedeal" target="_blank"><i class="ion-social-instagram"></i></a></li>
                        <li><a href="http://plus.google.com/grabbthedeal" target="_blank"><i class="ion-social-googleplus"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="column-4">
                <div class="footer-nav">
                    <h3 class="footer-title">Subscribe Us</h3>
                    <form id="footer-subscribe" action="//grabbthedeal.us14.list-manage.com/subscribe/post?u=3659ab6ce5796e871477790f2&amp;id=2729b5e6e7" method="post" name="mc-embedded-subscribe-form" novalidate>
                        <input type="email" class="footer-subscribe-input" name="email" placeholder="Enter your e-mail id" required>
                        <input type="submit" value="Submit">
                    </form>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="footer-attribution">
        <div class="container">
            <div class="column-12">
                <div class="attribution-text">
                    <p>&copy; Copyright 2016 - Grabb The Deal. All Rights Reserved.</p>
                    <div class="attribution-link">
                        {{--<a class="" href="http://manage-grabbthedeal.herokuapp.com/">Employee Login</a> <span class="pipe">&#124;</span>--}}
                        <a class="" href="{{secure_url('/contact')}}">Feedback</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="//cdn.grabbthedeal.in/assets/js/bower_components/js-cookie/src/js.cookie.js"></script>
<script src="//cdn.grabbthedeal.in/assets/js/bower_components/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js"></script>
<script src="//cdn.grabbthedeal.in/assets/js/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>
<script src="//cdn.grabbthedeal.in/assets/js/modernizr-output.js"></script>
{{--<script src="//cdn.grabbthedeal.in/assets/js/build/app.min.js"></script>--}}
<script src="{{asset('assets/js/build/app.min.js')}}"></script>
</body>
</html>