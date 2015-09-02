@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@endsection
@section('content')
    @include('partials.settings-header')
    <section class="content full admin">
        <h1>Edit Profile - {{ Auth::user()->email }}</h1>
        @include('errors.error-list')
        {!! Form::model(is_null($profile) ? new \RentGorilla\Profile() : $profile, ['route' => 'profile.update', 'files' => true]) !!}
        <label>Photo:

        @if( ! is_null($profile) && ! is_null($profile->photo))
            <br>
            <img src="{{ $profile->getPhoto() }}">
        @endif
        <br><small>
            <strong>Accepted formats:</strong> .gif, .png, .jpg, .bmp<br/>
            <strong>Maximum filesize:</strong> 10mb
        </small>
        </label>
            {!! Form::file('photo') !!}
        <br><br>
        <label>First Name:
            {!! Form::text('first_name', Auth::user()->first_name) !!}
        </label>
        <label>Last Name:
            {!! Form::text('last_name', Auth::user()->last_name) !!}
        </label>
        <label>Phone:
            {!! Form::text('primary_phone', null, ['placeholder'=> '902-555-5555']) !!}
        </label>
        <label>Alternate Phone:
            {!! Form::text('alt_phone', null, ['placeholder'=> '902-555-5555']) !!}
        </label>
        <label for="accepts_texts" class="">Accepts Text Messages:
            <span>
                {!! Form::radio('accepts_texts', 1) !!} Yes {!! Form::radio('accepts_texts', 0) !!} No
            </span>
        </label>
        <label>Company:
            {!! Form::text('company', null) !!}
        </label>
        <label>Website:
            {!! Form::text('website', null, ['placeholder'=> 'https://rentgorilla.ca']) !!}
        </label>
        <label>Bio:
            {!! Form::textarea('bio', null) !!}
        </label>
        <input type="submit" value="Update Profile">
        {!! Form::close() !!}
    </section>
@stop