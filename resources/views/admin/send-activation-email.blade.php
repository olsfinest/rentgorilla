@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-beta.3/css/select2.min.css" rel="stylesheet" />
@stop
@section('content')
    <section class="content full admin">
        <h1>Send Activation Email</h1>
        <p>Use this form to search for a user by email. Submitting the form sends a password reset email to that account .</p>
        @include('errors.error-list')
        {!! Form::open() !!}

        <select name="user_id" id="user_id" style=""></select>
        {!! Form::submit('Send Activation Email') !!}
        {!! Form::close() !!}
    </section>
@stop
@section('footer')

    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-beta.3/js/select2.min.js"></script>
    <script language="JavaScript" type="text/javascript">
        $('#user_id').select2({
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