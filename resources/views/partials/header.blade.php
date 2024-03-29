@include('partials.header-logo-login-signup')
<section id="signupmodal">
    <h1>Sign Up</h1>
    <h2>It's really easy.</h2>
    <div id="signup_errors"></div><br>
    {!! Form::open(['route' => 'register', 'id' => 'signup_form']) !!}
        <input type="text" id="signup_first_name" name="first_name" placeholder="First Name" class="">
        <input type="text" id="signup_last_name" name="last_name" placeholder="Last Name">
        <input type="email" id="signup_email" name="email" placeholder="Email Address">
        <input type="password" id="signup_password" name="password" placeholder="Password" class="firstpass">
        <input type="password" id="signup_password_confirmation" name="password_confirmation" placeholder="Confirm">
        <input type="submit" name="signup_submit" value="Create Account">
    {!! Form::close() !!}
    <p><a href="/terms">Terms</a> |
        <a class="login" href="#" title="Login with your RentGorilla account">Login</a>
    </p>
    <div class="social-login">
        <a style="color: white;" class="facebook no-margin" href="/login/facebook"><i class="fa fa-facebook"></i> Sign in with Facebook</a>
        <a href="/login/google"><img src="/img/google/btn_google_signin_light_normal_web.png"/></a>
    </div>
</section>
<a class="filter_toggle fa fa-bars"></a>
<section id="login">
    <h1>Login</h1><br>
    <div id="login_errors"></div><br>
    {!! Form::open(['route' => 'login', 'id' => 'login_form']) !!}
        <input type="email" id="login_email" name="email" placeholder="Email">
        <input type="password" id="login_password" name="password" placeholder="Password">
        <input type="submit" value="Login">
    {!! Form::close() !!}
    <p><a href="/password/email">Forgot password</a> or <a class="sign_up" href="#">Sign up</a></p><br>
    <div class="social-login">
        <a style="color: white;" class="facebook no-margin" href="/login/facebook"><i class="fa fa-facebook"></i> Sign in with Facebook</a>
        <a href="/login/google"><img src="/img/google/btn_google_signin_light_normal_web.png"/></a>
    </div>
</section>