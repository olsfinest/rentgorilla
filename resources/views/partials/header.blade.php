<header>
    <section class="main">
        <a title="RentGorilla... move on up." class="home" href="/">RentGorilla<small>Move on up</small></a>
        <div class="user_actions">
            @if( ! Auth::check())
                <button class="login">Login</button>
                <button class="sign_up">Sign up</button>
            @else
                <button class="logged_in">{{ Auth::user()->email }}</button>
            @endif
        </div>
    </section>
</header>
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
    <p><a href="#">FAQ</a> or <a href="#" class="login">Login</a></p>
</section>
<section id="login">
    <h1>Login</h1><br>
    <div id="login_errors"></div><br>
    {!! Form::open(['route' => 'login', 'id' => 'login_form']) !!}
        <input type="email" id="login_email" name="email" placeholder="Email">
        <input type="password" id="login_password" name="password" placeholder="Password">
        <input type="submit" value="Login">
    {!! Form::close() !!}
    <p><a href="/password/email">Forgot password</a> or <a class="sign_up" href="#">Sign up</a></p>
</section>
