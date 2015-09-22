@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')

    @include('partials.header')

    <section class="main">
        <article class="content full">

                <h2>Reset Password</h2>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @else
                    <p>Oops, looks like you misplaced your password. No problem, enter your email address here and we will email you a password reset link that you may use to choose a new password.</p>
                @endif


                @include('errors.error-list')

                <form method="POST" action="/password/email">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                   <label for="email">E-Mail Address
                        <input type="email" name="email" value="{{ old('email') }}">
                    </label>
                    <button type="submit" class="button">
                        Send Password Reset Link
                    </button>
                </form>
        </article>
    </section>
@endsection
