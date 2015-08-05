@include('partials.header-logo-login-signup')
<section id="signupmodal">
    <h1>Move on up.</h1>
    <h2>It's really easy.</h2>
    <img src="/img/escalator.png" alt="">
    <div id="signup_errors"></div><br>
    {!! Form::open(['route' => 'register', 'id' => 'signup_form']) !!}
        <input type="text" id="signup_first_name" name="first_name" placeholder="First Name" class="">
        <input type="text" id="signup_last_name" name="last_name" placeholder="Last Name">
        <input type="email" id="signup_email" name="email" placeholder="Email Address">
        <input type="password" id="signup_password" name="password" placeholder="Password" class="firstpass">
        <input type="password" id="signup_password_confirmation" name="password_confirmation" placeholder="Confirm">
        <input type="submit" name="signup_submit" value="Create Account">
    {!! Form::close() !!}
    <p><a href="#">FAQ</a> |
        <a class="login" href="#" title="Login with your RentGorilla account">Login</a>
    </p>
    <div>
        <a style="color: white;" class="facebook no-margin" href="/login/facebook"><i class="fa fa-facebook"></i> Sign up with Facebook</a>
        <a style="color: white;" class="google" href="/login/google"><i class="fa fa-google"></i> Sign up with Google</a>
    </div>
</section>
<section id="login">
    <h1>Login</h1><br>
    <div id="login_errors"></div><br>
    {!! Form::open(['route' => 'login', 'id' => 'login_form']) !!}
        <input type="email" id="login_email" name="email" placeholder="Email">
        <input type="password" id="login_password" name="password" placeholder="Password">
        <input type="submit" value="Login">
    {!! Form::close() !!}
    <p><a href="/password/email">Forgot password</a> or <a class="sign_up" href="#">Sign up</a></p><br>
    <div>
        <a style="color: white;" class="facebook no-margin" href="/login/facebook"><i class="fa fa-facebook"></i> Login with Facebook</a>
        <a style="color: white;" class="google" href="/login/google"><i class="fa fa-google"></i> Login with Google</a>
    </div>
</section>
