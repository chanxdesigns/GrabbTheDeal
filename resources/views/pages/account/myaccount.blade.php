@extends('layouts.master')
@section('title', Request::cookie('user_name'))

@section('content')
    {{-- Top Padding --}}
    <div class="top-pad"></div>

    {{-- Notification Bar --}}
    <div class="notification-topbar animated slideInDown"></div>

    <div class="background">
        <div class="container">
            <div class="row">
                <div class="column-3">
                    @include('pages.account.accountSidebar')
                </div>
                <div class="column-9">
                    <div class="account-content-wrapper">
                        <div class="user-info">
                            {{--
                            <div class="user-elem">
                                <div class="user-pic">
                                    <div class="img-wrapper">
                                        <img src="{{asset('assets/img/1412655_1107658055924846_7246674153726769016_o.jpg')}}">
                                    </div>
                                </div>
                            </div>
                            --}}
                            <div class="user-elem">
                                <div class="user-name">
                                    <h3>Hello {{Request::cookie('user_name')}}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="main-section-header">
                            <h1>Dashboard Summary</h1>
                        </div>

                        {{-- Dashboard Section Starts --}}
                        <section id="dashboard">
                            <div class="dashboard-summary">

                                @if ($user->available_balance || $user->pending_balance)
                                <div class="summary active-balance">
                                    <div class="text">
                                        <h3>Rs. {{floor($user->available_balance)}}</h3>
                                        <p>AVAILABLE BALANCE</p>
                                        <div class="tooltip small">This is the balance that you can withdraw, you can
                                            request for a bank transfer or in your Paytm Wallet.<br><a class="withdraw more"
                                                                                                      href="#withdrawals">Withdraw
                                                now</a></div>
                                    </div>
                                </div>

                                <div class="summary pending-balance">
                                    <div class="text">
                                        <h3>Rs. {{floor($user->pending_balance)}}</h3>
                                        <p>PENDING BALANCE</p>
                                        <div class="tooltip small">This is the pending balance which will be credited
                                            once we get confirmation from the retailers of your purchase, usually within
                                            30-45 days.
                                        </div>
                                    </div>
                                </div>
                                @else
                                    <div class="no-shop">
                                        <img class="no-shop-img" src="//cdn.grabbthedeal.in/assets/img/monster-angry.svg">
                                        <h3 class="no-shop-text">It seems you haven't bought anything yet.. Start shopping now to make this monster disappear and earn huge cashbacks on all items.</h3>
                                        <a class="button medium sunset" href="{{secure_url('/stores')}}">Go to Stores</a>
                                    </div>
                                @endif
                            </div>

                            {{-- Recent Activity Section  --}}

                            @if($activities)
                                <div class="section-header">
                                    <h3>Recent Activity</h3>
                                </div>

                                <div class="dashboard-activities">
                                    <table class="table">
                                        <thead class="table-header">
                                        <tr>
                                            <th>DATE</th>
                                            <th>MERCHANT</th>
                                            <th>CASHBACK EST.</th>
                                            <th>STATUS</th>
                                        </tr>
                                        </thead>

                                        <tbody class="table-body">
                                        @foreach($activities as $activity)
                                            <tr>
                                                <td><p>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $activity->created_at)->toDateString()}}</p></td>
                                                <td><p>{{$activity->merchant_name}}</p></td>
                                                <td><p>Rs. {{$activity->estimated_cashback}}</p></td>
                                                <td><p><span class="badge @if($activity->status === 'pending')warning
                                            @elseif($activity->status === 'completed')success
                                            @else danger @endif">{{ucfirst($activity->status)}}</span></p></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <a class="more" href="#activity">See more activities <span
                                                class="ion-ios-arrow-thin-right icons fw"></span></a>
                                </div>
                            @endif

                            {{-- Bonus Section  --}}

                            @if($bonuses)
                                <div class="section-header">
                                    <h3>Bonus</h3>
                                </div>

                                <div class="dashboard-bonuses">
                                    <table class="table">
                                        <thead class="table-header">
                                        <tr>
                                            <th>DATE</th>
                                            <th>BONUS TYPE</th>
                                            <th>AMOUNT</th>
                                            <th>STATUS</th>
                                        </tr>
                                        </thead>

                                        <tbody class="table-body">
                                        @foreach($bonuses as $bonus)
                                            <tr>
                                                <td><p>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $bonus->created_at)->toDateString()}}</p></td>
                                                <td><p>{{$bonus->bonus_type}}</p></td>
                                                <td><p>Rs. {{$bonus->bonus_amount}}</p></td>
                                                <td><p><span class="badge @if($bonus->status === 'pending')warning
                                            @elseif($bonus->status === 'completed')success
                                            @else danger @endif">{{ucfirst($bonus->status)}}</span></p></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <a class="more" href="#bonus">See more bonuses <span class="ion-ios-arrow-thin-right icons fw"></span></a>
                                </div>
                            @endif

                            {{-- Withdrawals Section  --}}

                            @if($withdrawals)
                                <div class="section-header">
                                    <h3>Withdrawals</h3>
                                </div>

                                <div class="dashboard-withdrawals">
                                    <table class="table">
                                        <thead class="table-header">
                                        <tr>
                                            <th>DATE</th>
                                            <th>TRANSACTION TYPE</th>
                                            <th>AMOUNT</th>
                                            <th>BANK REF. NO.</th>
                                            <th>STATUS</th>
                                        </tr>
                                        </thead>

                                        <tbody class="table-body">
                                        @foreach($withdrawals as $withdrawal)
                                            <tr>
                                                <td><p>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $withdrawal->created_at)->toDateString()}}</p></td>
                                                <td><p>{{strtoupper($withdrawal->withdrawal_channel)}}</p></td>
                                                <td><p>Rs. {{$withdrawal->amount}}</p></td>
                                                <td><p>@if ($withdrawal->bank_reference_number) {{strtoupper($withdrawal->bank_reference_number)}} @else Pending @endif</p></td>
                                                <td><p><span class="badge @if($withdrawal->status === 'pending')warning
                                            @elseif($withdrawal->status === 'completed')success
                                            @else danger @endif">{{ucfirst($withdrawal->status)}}</span></p></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <a class="more" href="#withdrawals">See more withdrawals <span
                                                class="ion-ios-arrow-thin-right icons fw"></span></a>
                                </div>
                            @endif

                            {{-- Referrals Section  --}}

                            @if($referrals)
                                <div class="section-header">
                                    <h3>Referrals</h3>
                                </div>

                                <div class="dashboard-referrals">
                                    <table class="table">
                                        <thead class="table-header">
                                        <tr>
                                            <th>USER ID</th>
                                            <th>NAME</th>
                                            <th>JOINED</th>
                                            <th>STATUS</th>
                                        </tr>
                                        </thead>

                                        <tbody class="table-body">
                                        @foreach($referrals as $referral)
                                            <tr>
                                                <td><p>{{$referral->user_id}}</p></td>
                                                <td><p>{{$referral->referred_user_name}}</p></td>
                                                <td><p>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $referral->created_at)->toDateString()}}</p></td>
                                                <td><p><span class="badge @if($referral->status) success @else danger @endif">@if($referral->status) Verified @else Unverified @endif</span></p></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <a class="more" href="#referrals">See more referrals <span
                                                class="ion-ios-arrow-thin-right icons fw"></span></a>
                                </div>
                            @endif
                        </section>

                        {{-- ------------------------

                        Dashboard Section Ends

                        --------------------------------------------------------------------------------}}

                        {{-- Activity Section --}}
                        <section id="activity">
                            <div class="activity-wrapper">
                                <table class="table">
                                    <table class="table">
                                        <thead class="table-header">
                                        <tr>
                                            <th>DATE</th>
                                            <th>MERCHANT</th>
                                            <th>CASHBACK EST.</th>
                                            <th>STATUS</th>
                                        </tr>
                                        </thead>

                                        <tbody class="table-body">
                                            {{-- Activity Lists --}}
                                        </tbody>
                                    </table>
                                </table>
                            </div>
                            <div class="pager">
                                <a class="prev" href=""><i class="ion-ios-arrow-thin-left icons fw"></i> Previous</a>
                                <a class="next" href="">Next <i class="ion-ios-arrow-thin-right icons fw"></i></a>
                            </div>
                        </section>

                        {{-- Bonus Section Starts --}}
                        <section id="bonus">
                            <table class="table">
                                <thead class="table-header">
                                <tr>
                                    <th>DATE</th>
                                    <th>BONUS TYPE</th>
                                    <th>AMOUNT</th>
                                    <th>STATUS</th>
                                </tr>
                                </thead>

                                <tbody class="table-body">
                                {{-- Bonuses lists --}}
                                </tbody>
                                <div class="pager">
                                    <a class="prev" href=""><i class="ion-ios-arrow-thin-left icons fw"></i> Previous</a>
                                    <a class="next" href="">Next <i class="ion-ios-arrow-thin-right icons fw"></i></a>
                                </div>
                            </table>
                        </section>
                        {{-- Bonus Section Ends --}}

                        {{-- Withdrawal Section Starts --}}
                        <section id="withdrawals">
                            {{-- Warning No Withdrawal Data --}}
                            @if (empty($user->bank_account_name) || empty($user->bank_account_number) || empty($user->bank_name) || empty($user->bank_ifsc_code) || empty($user->bank_address))
                            <div class="alert warning">
                                <p>Your withdrawal is disabled as your payment details are not up-to-date. <br>Please update your payment details from the <em>Payment Settings</em> tab.</p>
                            </div>
                            @endif

                            @if (!$user->validated)
                                <div class="alert warning">
                                    <p>Please verify your E-mail address. Check for a verification e-mail in your registered e-mail id.</p>
                                </div>
                            @endif
                            {{-- Withdrawal Form --}}
                            <div class="withdrawal-form-wrapper">
                                <p class="balance alert success">Your total withdrawable balance is: <strong>Rs. <span id="curr-available-balance">{{floor($user->available_balance)}}</span></strong></p>
                                <form id="withdrawal-form" method="post" action="">
                                    {{csrf_field()}}
                                    <input type="hidden" id="available-balance" value="{{floor($user->available_balance)}}">
                                    <span id="amt-denom">Rs.</span><input type="number" id="withdrawal-amount"
                                                                          name="withdrawal-amount" placeholder="Enter amount" @if (empty($user->bank_account_name) || empty($user->bank_account_number) || empty($user->bank_name) || empty($user->bank_ifsc_code) || empty($user->bank_address) || !$user->validated) disabled @endif required/>
                                    <select id="withdrawal-channel" name="withdrawal-channel" @if (empty($user->bank_account_name) || empty($user->bank_account_number) || empty($user->bank_name) || empty($user->bank_ifsc_code) || empty($user->bank_address) || !$user->validated) disabled @endif>
                                        <option value="neft">NEFT</option>
                                    </select>
                                    <input type="submit" id="withdraw-submit" value="WITHDRAW NOW" @if (empty($user->bank_account_name) || empty($user->bank_account_number) || empty($user->bank_name) || empty($user->bank_ifsc_code) || empty($user->bank_address) || !$user->validated) disabled @endif>
                                    <img class="loader2" src="/assets/img/loader-2.gif">
                                </form>
                                <span class="small failed"></span>
                            </div>
                            <div class="second-header">
                                <h3>History</h3>
                            </div>
                            <table class="table">
                                <thead class="table-header">
                                <tr>
                                    <th>DATE</th>
                                    <th>TRANSACTION TYPE</th>
                                    <th>AMOUNT</th>
                                    <th>BANK REF. NO.</th>
                                    <th>STATUS</th>
                                </tr>
                                </thead>

                                <tbody class="table-body">
                                {{-- Withdrawal lists --}}
                                </tbody>
                            </table>
                            <div class="pager">
                                <a class="prev" href=""><i class="ion-ios-arrow-thin-left icons fw"></i> Previous</a>
                                <a class="next" href="">Next <i class="ion-ios-arrow-thin-right icons fw"></i></a>
                            </div>
                        </section>
                        {{-- Withdrawal Section Ends --}}

                        {{-- Referral Section Starts --}}
                        <section id="referrals">
                            <div class="referral-header-img">
                                <img src="//cdn.grabbthedeal.in/assets/img/cropped-friends.jpg">
                            </div>
                            <div class="referral-outer-header">
                                <h1>Invite and get <strong><span class="">Rs. 200</span></strong> cashback</h1>
                            </div>
                            <div class="referrals-content-wrapper">
                                <div class="referral-content">
                                    <div class="referral-body">
                                        <h3 class="ref-body-header">Invite your friends to join Grabb The Deal and earn referral bonus of <span class="pink">Rs. 200</span></h3>
                                        <p class="ref-body-sub-header">Your friend also earns Rs. 100, <a class="more-info-tooltip" href="#">more info.</a> </p>
                                        <div class="process email">
                                            <h3 class="process-header">Have an email id? Refer using email</h3>
                                            <form id="refer-mail" method="post" action="">
                                                <input type="email" id="referree-mail" name="referree-mail" placeholder="Enter your friend's e-mail" required/>
                                                <input type="submit" id="referral-submit" value="INVITE NOW">
                                                <p class="small">You can enter multiple emails separated by commas.</p>
                                            </form>
                                        </div>
                                        <div class="process manual">
                                            <div class="referral-link">
                                                <h3 class="process-header">Alternatively you may copy & share the link</h3>
                                                <form id="refer-manual" method="post" action="">
                                                    <input type="text" value="http://www.grabbthedeal.in/register/?ref-id={{$user->referral_code}}" readonly>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="section-header">
                                <h3>Referral & Credits History</h3>
                            </div>

                            <table class="table">
                                <thead class="table-header">
                                <tr>
                                    <th>USER ID</th>
                                    <th>NAME</th>
                                    <th>JOINED</th>
                                    <th>STATUS</th>
                                </tr>
                                </thead>

                                <tbody class="table-body">
                                {{-- Referrals lists --}}
                                </tbody>
                            </table>
                        </section>
                        {{-- Referral Section Starts --}}

                        {{-- Profile Section Starts --}}
                        @include('pages.account.partials.profilePartial')
                        {{-- Profile Section Ends --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection