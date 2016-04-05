@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-beta.3/css/select2.min.css" rel="stylesheet" />
@stop
@section('content')
    <section class="content full admin">

        <h1>Search By Email</h1>
        <p>Use this form to search for a user by email. Submitting the form will log you into that account.</p>
        @include('errors.error-list')
        {!! Form::open() !!}
         <select name="user_id" class="user_id" style=""></select>
        {!! Form::submit('Become') !!}
        {!! Form::close() !!}
        <br>

        <hr>

        <h1>Search By Address</h1>
        <p>Use this form to search for a user by property address. Submitting the form will log you into that account.</p>
        @include('errors.error-list')
        {!! Form::open() !!}
        <select name="user_id" id="address" style=""></select>
        {!! Form::submit('Become') !!}
        {!! Form::close() !!}
        <br>

        <hr>

        <h1>Edit / Delete User By Email</h1>
        <p>Use this form to edit or delete a user by email.</p>
        @include('errors.error-list')
        {!! Form::open(['route' => 'admin.user.editUserByEmail']) !!}
        <select name="user_id" class="user_id" style=""></select>
        {!! Form::submit('Edit / Delete') !!}
        {!! Form::close() !!}
        <br>

        <hr>

        <h1>All Users ({{ $users->total() }})</h1>
        <table class="users" width="100%">
            <thead>
            <tr>
                <th>{!! sort_users_by('email', 'Email') !!}</th>
                <th>{!! sort_users_by('first_name', 'First') !!}</th>
                <th>{!! sort_users_by('last_name', 'Last') !!}</th>
                <th>{!! sort_users_by('rentalsCount', 'Rentals') !!}</th>
                <th>{!! sort_users_by('stripe_active', 'Subscribed') !!}</th>
                <th>{!! sort_users_by('stripe_plan', 'Plan ID') !!}</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr class="">
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->rentalsCount }}</td>
                    <td>{{ $user->stripeIsActive() ? 'Yes' : 'No' }}</td>
                    <td>{{ $user->stripe_plan ?: 'n/a' }}</td>
                    <td>{!! Form::open() !!}
                        <input type="hidden" name="user_id" value="{{ $user->id }}" >
                        {!! Form::submit('Become') !!}
                        {!! Form::close() !!}
                    </td>
                    <td><a class="button" href="{{ route('admin.user.edit', $user->id) }}">Edit</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination">
            {!! $users->appends(Request::except('page'))->render() !!}
        </div>
    </section>

@stop
@section('footer')

<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-beta.3/js/select2.min.js"></script>
<script language="JavaScript" type="text/javascript">

    $('#address').select2({
        minimumInputLength: 3,
        placeholder: 'Address',
        ajax: {
            type: 'POST',
            url: '/address-search',
            dataType: 'json',
            data: function (term, page) {
                return {
                    address: term
                };
            },
            processResults: function (data, page) {
                return {results: data};
            }
        }
    });


    $('.user_id').select2({
        minimumInputLength: 3,
        placeholder: 'Email',
        ajax: {
            type: 'POST',
            url: '/email-search',
            dataType: 'json',
            data: function (term, page) {
                return {
                    email: term
                };
            },
            processResults: function (data, page) {
                return {results: data};
            }
        }
    });

</script>
@stop