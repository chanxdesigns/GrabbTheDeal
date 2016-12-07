@extends('layouts.master')
@section('title', 'How Grabb The Deal Works In Giving You Cashbacks & Offers')

@section('content')
    <div class="top-pad"></div>
    <div class="how-it-works-header-wrapper">
        <div class="container">
            <h1 class="header-text">Know How We Work</h1>
        </div>
    </div>
    <div class="how-it-works-details">
        <div class="how-it-works-excerpt">
            <h3>You came here searching for top offers and a way to reduce the price on your favorite products, look no
                further.<br><br>
                Since our mission is to make users shop more and more, we will help you in achieving the said goals very
                easily.</h3>
        </div>
        <div class="how-it-works-home">
            <div class="container">
                <h3 class="title">How it works?</h3>
                <div class="column-4">
                    <div class="how-wrapper-home">
                        <div class="img-container">
                            <img src="//cdn.grabbthedeal.in/assets/img/how-it-works-1.svg">
                        </div>
                        <h3 class="title">1. Browse offers</h3>
                        <p>Browse and find your favorite item with great deals from the top stores.</p>
                    </div>
                </div>
                <div class="column-4">
                    <div class="how-wrapper-home">
                        <div class="img-container">
                            <img src="//cdn.grabbthedeal.in/assets/img/how-it-works-2.svg">
                        </div>
                        <h3 class="title">2. Shop it</h3>
                        <p>Click through our link and shop the item from your favorite store as usual.</p>
                    </div>
                </div>
                <div class="column-4">
                    <div class="how-wrapper-home">
                        <div class="img-container">
                            <img src="//cdn.grabbthedeal.in/assets/img/how-it-works-3.svg">
                        </div>
                        <h3 class="title">3. Get cashbacks</h3>
                        <p>Now everything is set, we will track your purchase and credit the cash to your account!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="how-it-works-explained">
        <div class="container">
            <h3 class="title">Above Steps Explained</h3>
        </div>
        <div class="step even">
            <div class="container">
                <div class="step-text">
                    <h3 class="step-title">Browse through our 1000+ offers database</h3>
                    <p class="step-body">
                        Browse through our 1000+ offers database. Visit offers, stores section or search your product
                        using name, store or any other relevant details. We will display a list of the latest hot deals
                        and your matched offers.
                    </p>
                </div>
                <div class="step-img even">
                    <div class="image-wrapper">
                        <img src="//cdn.grabbthedeal.in/assets/img/how-it-works-explained-1.svg">
                    </div>
                </div>
            </div>
        </div>
        <div class="step odd">
            <div class="container">
                <div class="step-img odd">
                    <div class="image-wrapper">
                        <img src="//cdn.grabbthedeal.in/assets/img/how-it-works-explained-2.svg">
                    </div>
                </div>
                <div class="step-text">
                    <h3 class="step-title">Click through Grabb The Deal and Shop from your favorite store</h3>
                    <p class="step-body">
                        After you have browsed and selected your favorite offer, just click on the "<strong>Grabb The Deal</strong>" button to visit the offer site. Complete the shopping process in the same session and don't visit any other coupon/casback website.
                    </p>
                </div>
            </div>
        </div>
        <div class="step even">
            <div class="container">
                <div class="step-text">
                    <h3 class="step-title">Cashback credited as pending balance within 3 hours</h3>
                    <p class="step-body">
                        Once your shopping is done, we will track your purchase and update your account with the cashback amount as pending balance once notified by our partner store. Your pending balance will be updated within 3 hours.
                    </p>
                </div>
                <div class="step-img even">
                    <div class="image-wrapper">
                        <img src="//cdn.grabbthedeal.in/assets/img/how-it-works-explained-3.svg">
                    </div>
                </div>
            </div>
        </div>
        <div class="step odd">
            <div class="container">
                <div class="step-img odd">
                    <div class="image-wrapper">
                        <img src="//cdn.grabbthedeal.in/assets/img/how-it-works-explained-4.svg">
                    </div>
                </div>
                <div class="step-text">
                    <h3 class="step-title">Withdraw your balance to your wallet/bank</h3>
                    <p class="step-body">
                        As soon as our partner store pays us, your pending balance will be converted to available balance and you can withdraw it using your choice of withdrawal methods such as online wallet or bank transfer.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="start-shopping-wrapper">
        <a href="{{route('stores')}}" class="button medium blue">Start shopping now</a>
    </div>
@endsection
