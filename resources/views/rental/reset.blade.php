@extends('layouts.admin')
@section('head')
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/form.css?v=2">
@stop
@section('content')
<script   src="https://code.jquery.com/jquery-1.11.1.min.js"   integrity="sha256-VAvG3sHdS5LqTT+5A/aeq/bZGa/Uj04xKxY8KM/w9EE="   crossorigin="anonymous"></script>


    <section class="content full admin">
        <h1><i class="fa fa-pencil-square"></i> Reset Statistics</h1>
		Are you sure you want to reset statistics for this property? This action cannot be undone.
       
        {!! Form::model($rental, ['method' => 'PATCH', 'route' => ['rental.update', $rental->uuid], 'class' => 'form-horizontal', 'id' => 'modify_rental_form']) !!}
		
		<input type="hidden" name="resetsubmit" value="resetsubmit" />
		<input type="hidden" name="userid" value="{{ $rental->user_id }}" />
		<input type="hidden" name="rentalid" value="{{ $rental->id }}" />
		
        @include('rental.form', ['submitButtonText' => 'Update'])
		<input  type="submit" class="button buttonupdate" value="Reset">
        {!! Form::close() !!}
        <a href="{{ route('dashboard.index') }}" class="button buttonupdate">Cancel</a>
    </section>
	<style>
	fieldset , .button { display:none!important; }
	.buttonupdate { display:block!important; }
	.requiredNote { display:none; }
	form label { display:none; }
	</style>

@stop