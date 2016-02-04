@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@endsection
@section('content')
    @include('partials.settings-header')
    <section class="content full admin">
        <h1 class="editProfileTitle"><strong><i class="fa fa-user"></i> Edit Profile</strong></h1>
        @include('errors.error-list')
        {!! Form::model(is_null($profile) ? new \RentGorilla\Profile() : $profile, ['route' => 'profile.update', 'files' => true]) !!}

        <!-- Email Address -->
        <div class="settingsPanel">
            <span class="settingsLabel">
                <label for=""><i class="fa fa-envelope"></i> Email Address</label>
                <p><small>This is used to log into RentGorilla.ca, and it's how we keep in touch with you.</small></p>
            </span>
            <span class="settingsContent">
                <p>{{ Auth::user()->email }}</p>
            </span>
            <div class="cf"></div>
        </div>

        <!-- Password -->
        <div class="settingsPanel">
            <span class="settingsLabel">
                <label><i class="fa fa-lock"></i> Change Password</label>
                <p><small>
                    In case you can't remember the current one, or if you'd simply like to update it.
                </small></p>
            </span>
            <span class="settingsContent"><p> <a href="/password/email"><strong>Click here</strong></a>, enter your email address, and a reset link will be sent to you.</p></span>
            <div class="cf"></div>
        </div>
        
        <!-- Profile Photo -->
        <div class="settingsPanel">
            <span class="settingsLabel">
                <label>
                    <i class="fa fa-photo"></i> Photo:
                </label>
                <p>
                    <small>
                        Your photo is represented in the header bar and on any properties you have listed.    
                    </small>
                </p>
            </span>
            <span class="settingsContent">
                @if( ! is_null($profile) && ! is_null($profile->photo))
                    <img class="settingsPhoto" width="100" height="100" src="{{ $profile->getPhoto() }}">
                @endif
                {!! Form::file('photo') !!}
                <p>
                    <small>
                        <strong>Accepted formats:</strong> .gif, .png, .jpg, .bmp<br/>
                        <strong>Maximum filesize:</strong> 10mb
                    </small>
                </p>
            </span>
            <div class="cf"></div>
        </div>

        <!-- Bio / Details -->
        <div class="settingsPanel">
            <span class="settingsLabel">
                <label for=""><i class="fa fa-info-circle"></i> Your information</label>
                <p><small>This information helps us keep in touch, and helps us connect you with the right renters.</small></p>
            </span>
            <span class="settingsContent">
                <label class="half left">First Name:
                    {!! Form::text('first_name', Auth::user()->first_name) !!}
                </label>
                <label class="half right">Last Name:
                    {!! Form::text('last_name', Auth::user()->last_name) !!}
                </label>
                <label class="half left">Company:
                    {!! Form::text('company', null) !!}
                </label>
                <label class="half right">Website:
                    {!! Form::text('website', null, ['placeholder'=> 'https://rentgorilla.ca']) !!}
                </label>
                <label class="half left">Phone:
                    {!! Form::text('primary_phone', null, ['placeholder'=> '902-555-5555']) !!}
                </label>
                <label class="half right">Alternate Phone:
                    {!! Form::text('alt_phone', null, ['placeholder'=> '902-555-5555']) !!}
                </label>
                <label for="accepts_texts" class="">Phone Accepts Text Messages:
                    <span>
                        {!! Form::radio('accepts_texts', 1) !!} Yes {!! Form::radio('accepts_texts', 0) !!} No
                    </span>
                </label>
                <label>Bio:
                    {!! Form::textarea('bio', null) !!}
                </label>
            </span>
            <div class="cf"></div>
        </div>

        <!-- Send -->
        <input type="submit" value="Update Profile">
        {!! Form::close() !!}
        <script>
            var d = document.querySelector(".admin form");
            d.className += "profileForm";
        </script>
    </section>
@stop