<h1>Account Unconfirmed</h1><br>
<p>Oops! Looks like you haven't yet confirmed your email address. Please check your email or click the button below to resend your confirmation.</p>
<div id="unconfirmed_account_errors"></div><br>
{!! Form::open(['route' => 'resend.confirmation', 'id' => 'unconfirmed_account_form']) !!}
<input type="hidden" name="email" value="{{ $email }}">
<input type="submit" value="Resend Confirmation Email">
{!! Form::close() !!}<br>