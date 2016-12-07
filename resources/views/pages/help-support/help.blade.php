@extends('layouts.master')
@section('title', 'Help, Support & FAQ')
@section('content')
    <div class="top-pad"></div>
    <div class="container">
        <div class="column-3">
            @include('pages.help-support.helpSidebar')
        </div>
        <div class="column-9">
            <div class="faq-wrapper">
                <h3 class="title">Frequently Asked Questions</h3>
                <p class="sub-title">Below you can find the answers of general and frequently asked questions. <br/>If your query answer doesn't exists, please don't hesitate to contact us -- <a href="mailto:care@grabbthedeal.in">care@grabbthedeal.in</a>.</p>
                <div class="faq-body">
                    <ul>
                        <li>
                            <a class="faq-question">
                                <h3 class="faq-question-text">What is Grabb The Deal?</h3>
                                <p class="faq-answer">
                                    Grabb The Deal is a cashback website where we provide our users certain percentage of their shopping amount for shopping through us.
                                </p>
                            </a>
                        </li>
                        <li>
                            <a class="faq-question">
                                <h3 class="faq-question-text">How does Grabb The Deal work?</h3>
                                <p class="faq-answer">
                                    We are partnered with around 300+ stores which provides us with commissions for every transactions made through us which in turn is provided to you.
                                </p>
                            </a>
                        </li>
                        <li>
                            <a class="faq-question">
                                <h3 class="faq-question-text">Which retailers can I save on Grabb The Deal?</h3>
                                <p class="faq-answer">
                                    Grabb The Deal is partnered with around 300+ stores which includes the likes of Flipkart, Amazon, Myntra, Jabong .etc and many other leading online shopping sites of India.
                                </p>
                            </a>
                        </li>
                        <li>
                            <a class="faq-question">
                                <h3 class="faq-question-text">Is Grabb The Deal payable to use?</h3>
                                <p class="faq-answer">
                                    No, Grabb The Deal is completely free to use and we don't charge our users any sort of fees for using our services.
                                </p>
                            </a>
                        </li>
                        <li>
                            <a class="faq-question">
                                <h3 class="faq-question-text">How can I contact Grabb The Deal?</h3>
                                <p class="faq-answer">
                                    You can reach Grabb The Deal at: care@grabbthedeal.in or call us at our number: +919167583967
                                </p>
                            </a>
                        </li>
                        <li>
                            <a class="faq-question">
                                <h3 class="faq-question-text">What is Pending Balance?</h3>
                                <p class="faq-answer">
                                    You will get Pending balance credited when our partner merchant confirms your transaction with them. This balance is not withdrawable. It's just provided so that you can understand how much you will receive for your transactions.
                                </p>
                            </a>
                        </li>
                        <li>
                            <a class="faq-question">
                                <h3 class="faq-question-text">What is Available Balance?</h3>
                                <p class="faq-answer">
                                    This is the amount for the transaction that is successfully confirmed and credited to us by our partner merchant. This balance is withdrawable.
                                </p>
                            </a>
                        </li>
                        <li>
                            <a class="faq-question">
                                <h3 class="faq-question-text">How long does it take for the cashback amount to be credited?</h3>
                                <p class="faq-answer">
                                    Your cashback amount will be credited to your Pending balance amount within max 72 hrs of your shopping. This will be converted to Available balance within 30 days of your shopping as merchants take 30 days time limit to confirm any purchase.
                                </p>
                            </a>
                        </li>
                        <li>
                            <a class="faq-question">
                                <h3 class="faq-question-text">Where can I see my Pending and Available balance?</h3>
                                <p class="faq-answer">
                                    You can see your Pending and Available balance in your My Account > Dashboard area. Login to your account and click on Dashboard tab, you can see your Available as well as Pending amount balance.
                                </p>
                            </a>
                        </li>
                        <li>
                            <a class="faq-question">
                                <h3 class="faq-question-text">How can I withdraw money?</h3>
                                <p class="faq-answer">
                                    Grabb The Deal supports multiple withdrawal methods such as Wallet and Bank NEFT transfers.
                                </p>
                            </a>
                        </li>
                        <li>
                            <a class="faq-question">
                                <h3 class="faq-question-text">How long does it take for the withdrawal to be credited to my account?</h3>
                                <p class="faq-answer">
                                    Withdrawal in Grabb The Deal takes 1 days to process for wallet transactions and 3 days for NEFT transactions. This is just the standard time required for such transactions although they happen much faster.
                                </p>
                            </a>
                        </li>
                        <li>
                            <a class="faq-question">
                                <h3 class="faq-question-text">I haven't received any cashback e-mail for the purchase I made. What can I do?</h3>
                                <p class="faq-answer">
                                    Please wait for 72 hrs, as our partner merchant takes 72 hrs to confirm the validity of the transactions. You may receive the cashback e-mail anytime within the stipulated max timeframe. However if you don't receive any e-mail within 72 hrs, please raise a support ticket by logging in to your My Account > Support area.
                                </p>
                            </a>
                        </li>
                        <li>
                            <a class="faq-question">
                                <h3 class="faq-question-text">How can I submit a Missing Cashback request ticket?</h3>
                                <p class="faq-answer">
                                    You can submit a missing cashback request ticket by logging in to your My Account > Support area. Select Cashback Transactions from the dropdown menu and provide us with the retailer name, date and time of the transaction, transaction amount, order or transaction reference, and any other details that would help the retailer to track your transaction.
                                </p>
                            </a>
                        </li>
                        <li>
                            <a class="faq-question">
                                <h3 class="faq-question-text">What are the reasons for cashback not tracking properly?</h3>
                                <p class="faq-answer">
                                    Our sophisticated system tracks every transaction you make. Thereafter if you don't receive an e-mail from us within 72 hrs then most probably the retailer has missed your transaction. In such cases, you may raise a missing cashback ticket or contact us at missing@grabbthedeal.in.<br>
                                    There are many reasons for cashback not being tracked properly.<br><br>
                                    <strong>The most popular reasons are:</strong><br>
                                    <em>Cookie not enabled in browser.</em><br>
                                    <em>Invalid voucher or coupon code.</em><br>
                                    <em>Failure to comply with terms & conditions listed on our website\partner site</em><br>
                                    <em>The purchase was not wholly completed online.</em><br><br>
                                    We advise our users to stick to the terms & conditions of our website\partner site and ensure you follow the recommended process to avoid any problems.
                                </p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            {{-- Support Form --}}
            <div class="support-wrapper">
                <div class="support-body">
                    <form class="" id="help-support" method="post" action="{{secure_url('/support/request')}}">
                        <div class="input-group">
                            <label for="support"></label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection