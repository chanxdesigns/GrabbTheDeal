{{--------------------------------------------
 * Login Partial
 *
 * Grabb The Deal/Login
 ****---------------------------------------}}
<div class="notification-topbar danger animated slideInDown"></div>
<div class="login-wrapper">
    <div class="login">
        <div class="modal-header">
            <img src="//cdn.grabbthedeal.in/assets/img/close.svg" class="pull-right close">
            <h3>LOGIN TO GRABB THE DEAL</h3>
            <p>Start earning huge cashbacks on all items</p>
        </div>

        <form class="login-form" method="post" action="{{route('login')}}">
            {{csrf_field()}}
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="text" id="email" placeholder="Enter your e-mail id" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Choose your password" required>
            </div>
            <a class="password-forgot" href="{{secure_url('/password/reset')}}">Forgot Password?</a>
            <div class="form-group">
                <input type="submit" id="submit" value="Login now">
            </div>
        </form>
        {{---------------------------
         *
         * Social Login
         ------------------------
        <p class="or">Or</p>
        <div class="social-login">
            <button class="facebook-login" href="" onclick="detectUserStatus()"><i class="fa fa-facebook"></i> &nbsp; Login using Facebook</button>
        </div>
        <div class="social-login pull-right">
            <button class="google-login" href=""><i class="fa fa-google-plus"></i> &nbsp; Login using Google+</button>
        </div>
        <div class="clearfix"></div>
        --}}
        <div class="modal-footer">
            <div class="not-member">
                <p>Not already a member? <a href="{{route('register')}}" class="signup popup-register">Register</a></p>
            </div>
        </div>
    </div>
</div>