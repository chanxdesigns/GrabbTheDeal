{{--------------------------------------------
* Register Partial
*
* Grabb The Deal/Register
****-----------------------------------}}

<div class="register-wrapper">
    <div class="register">
        <div class="notification-topbar danger animated slideInDown"></div>
        <div class="modal-header">
            <img src="//cdn.grabbthedeal.in/assets/img/close.svg" class="pull-right close">
            <h3>SIGN UP FOR GRABB THE DEAL</h3>
            <p>Register now and get Rs. 150 joining bonus.</p>
        </div>

        <div class="row" id="toggleForm">
            <form class="register-form" method="post" action="{{route('register')}}">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" placeholder="Enter your full name">
                </div>
                <div class="form-group pull-right">
                    <label for="email">Email Address</label>
                    <input type="email" id="reg-email" name="email" placeholder="Enter your e-mail id" required>
                </div>
                <div class="clearfix"></div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="reg-password" name="password_confirmation" placeholder="Choose your password" required>
                    <p class="help-block failed"></p>
                </div>
                <div class="form-group pull-right">
                    <label for="password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="password" placeholder="Re-enter your password" required>
                    <p class="help-block failed"></p>
                </div>
                <div class="clearfix"></div>
                <div class="form-group">
                    <label for="referral_code">Referral Code</label>
                    <input type="text" id="referral_code" name="referral_code" placeholder="Enter your referral code">
                </div>
                <div class="form-group pull-right">
                    <label></label>
                    <input type="submit" id="submit-register" value="Sign up now">
                </div>
            </form>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <div class="not-member">
                    <p>Already a member? <a href="#login" class="signin popup-register">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</div>