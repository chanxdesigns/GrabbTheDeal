{{-- Profile Section Starts --}}
<section id="profile">
    <div class="loader-backdrop"></div>
    <div class="profile-wrapper">
        <div class="profile-settings">
            <form id="profile-update" method="post" action="">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Full name</label>
                    <input type="text" id="name" name="name" value="">
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="prof-email" name="email" readonly>
                    <p class="small">You can't change the email address. It is shown for reference purpose only.</p>
                </div>
                <div class="form-group">
                    <label for="phone">Phone number</label>
                    <input type="text" id="phone" name="phone" value="">
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <input type="radio" id="male" name="gender" value="m"><span>Male</span>
                    <input type="radio" id="female" name="gender" value="f"><span>Female</span>
                </div>
                <input type="submit" value="Update Profile">
            </form>
        </div>
    </div>
</section>
{{-- Profile Section Ends --}}

{{-- Payment Settings Section Starts --}}
<section id="payment">
    <div class="loader-backdrop"></div>
    <div class="payment-wrapper">
        <div class="payment-settings">
            <div id="preferred-channel">
                {{--
                <select name="channel" id="channel">
                    <option value="neft" selected>NEFT/Bank Transfer</option>
                    <option value="amazon">Amazon Gift Coupons</option>
                </select>
                --}}
                <form id="bank-transfer">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="bank-account-name">Bank Account Name</label>
                        <input id="bank-account-name" name="bank-account-name" placeholder="Enter your bank account name"
                               value="">
                    </div>
                    <div class="form-group">
                        <label for="bank-account-number">Bank Account Number</label>
                        <input id="bank-account-number" name="bank-account-number" placeholder="Enter your bank account number" value="">
                    </div>
                    <div class="form-group">
                        <label for="bank-name">Bank Name</label>
                        <input id="bank-name" name="bank-name" placeholder="Enter your bank name" value="">
                    </div>
                    <div class="form-group">
                        <label for="bank-ifsc">IFS Code</label>
                        <input id="bank-ifsc" name="bank-ifsc" placeholder="Enter your bank IFS Code" value="">
                    </div>
                    <div class="form-group">
                        <label for="bank-address">Bank Address</label>
                        <textarea id="bank-address" rows="3" name="bank-address" placeholder="Enter your bank address" value=""></textarea>
                    </div>
                    <input type="submit" value="SUBMIT">
                </form>
            </div>
        </div>
    </div>
</section>
{{-- Payment Settings Section Ends --}}

{{-- Support Section Starts --}}
<section id="support">
    <div class="loader-backdrop"></div>
    <div class="support-wrapper">
        <form id="support-form" method="post" action="">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="support-ticket">Support Ticket</label>
                <input type="text" name="support-ticket" id="support-ticket" placeholder="Click to generate a support ticket" required readonly>
                <input type="button" id="support-ticket-generate" value="Generate">
            </div>
            <div class="form-group">
                <label for="support-category">Support Category</label>
                <select name="support-category" id="support-category">
                    <option value="site">Site Usage</option>
                    <option value="cashback">Cashback Transactions</option>
                    <option value="withdrawal">Withdrawals</option>
                    <option value="oth">Others</option>
                </select>
            </div>
            <div class="form-group">
                <label for="support-query">Your Message</label>
                <textarea rows="10" name="support-query" id="support-query"></textarea>
            </div>
            <input type="submit" value="SEND MESSAGE">
        </form>
    </div>
</section>