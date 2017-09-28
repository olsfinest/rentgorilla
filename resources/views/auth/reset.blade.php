@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    @include('partials.header')

    <section class="main">
        <article class="content full">

            <h2>Set New Password</h2>

            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="/password/reset">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="token" value="{{ $token }}">

                <label for="email">E-Mail Address
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                </label>
                <label for="password">Password
                        <input type="password" class="form-control" name="password">
                </label>
                <label for="password_confirmation">Confirm Password
                        <input type="password" class="form-control" name="password_confirmation">
                </label>
                <button type="submit" class="button">
                        Set New Password
                </button>
            </form>
        </article>
    </section>
@endsection
