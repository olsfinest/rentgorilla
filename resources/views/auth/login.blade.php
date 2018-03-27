@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="/css/login.css?v=1" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/css/form.css" media="screen" title="no title" charset="utf-8">
@endsection

@section('content')
<script type="text/javascript">
    document.body.classList.add("login_only");
</script>
<section class="main">
    <header>
        <section class="main">
            <a title="RentGorilla... move on up." class="home" href="/">RentGorilla<small>Move on up</small>
            <span class="eyes" title="Did you know that gorillas blink approximately 30 times per minute? That's once every 2 seconds!">
                <span class="eye left"></span>
                <span class="eye right"></span>
            </span>
            </a>
            </section>
       </header>
    <section class="content full pricing">
        @include('errors.error-list')
        <div class="loginOnly">
            {!! Form::open(['route' => 'login']) !!}
                <input placeholder="Your email address" type="email" name="email" value="" autofocus tabindex="1" required>
                <input placeholder="Your password" type="password" name="password" value="" tabindex="2" required>
                <input placeholder="" type="submit" name="submit" value="Log In" tabindex="3">
           {!! Form::close() !!}
            <a class="forgotPass" href="password/email">Reset password</a>
        </div>

        <div class="loginOnly">
            <a class="facebook" href="/login/facebook"><i class="fa fa-facebook"></i> Login with Facebook</a>
            <a class="google" href="/login/google"><i class="fa fa-google"></i> Login with Google</a>
        </div>
    </section>
</section>
@endsection