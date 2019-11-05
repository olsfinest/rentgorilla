@extends('layouts.admin')
@section('head')
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/form.css?v=2">
@stop
@section('content')
<script   src="https://code.jquery.com/jquery-1.11.1.min.js"   integrity="sha256-VAvG3sHdS5LqTT+5A/aeq/bZGa/Uj04xKxY8KM/w9EE="   crossorigin="anonymous"></script>
<script>
	
	$(window).scroll(function(){
	  var sticky = $('.sticky'),
		  scroll = $(window).scrollTop();

	  if (scroll >= 100) sticky.addClass('fixed2');
	  else sticky.removeClass('fixed2');
	});

	</script>
<div class="listing-edit sticky" id="listing-edit"><section class="content full"><p><strong>Please Note:</strong> Your Listing Must Be Set To Active To Be Visible To The Public</p><input data-toggle="modal" data-target="#confirm-submit" type="button" class="button right" value="Update"><a href="https://rentgorilla.ca/rental" class="button rightlink">Cancel</a></section><br style="clear:both;" /></div>

    <section class="content full admin">
        <h1><i class="fa fa-pencil-square"></i> Edit rental</h1>
        @include('errors.error-list')
        {!! Form::model($rental, ['method' => 'PATCH', 'route' => ['rental.update', $rental->uuid], 'class' => 'form-horizontal', 'id' => 'modify_rental_form']) !!}
        @include('rental.form', ['submitButtonText' => 'Update'])
        {!! Form::close() !!}
        <a href="{{ route('rental.index') }}" class="button">Cancel</a>
    </section>
	
<script>
	jQuery('#submitmodal').click(function(){	
			$('#modify_rental_form').submit();
	});
				
	$(".button").prop("type", "button");
	
	var chk1 = jQuery('#active1');
	var chk2 = jQuery('#active');

	chk1.on('click', function(){
		if( chk1.is(':checked') ) {
			chk2.attr('checked', true);
		} else {
			chk2.attr('checked', false);
		}
	});	
	
	
	$('ul.errors li').each(function() {
		
    var text = $(this).text();
	
		$(this).text(text.replace('The beds field is required.', 'Bedrooms field is required.')); 
		
	
	});
	
	$('ul.errors li').each(function() {
		
    var text = $(this).text();
	
	
		$(this).text(text.replace('The available field is required.', 'Date Available field is required.')); 
	
	
	});
	
	$('ul.errors li').each(function() {
		
    var text = $(this).text();
	
	
		
		$(this).text(text.replace('The baths field is required.', 'Bathrooms field is required.')); 
	
	});
	
	$('ul.errors li').each(function() {
		
    var text = $(this).text();
	
	
		
		$(this).text(text.replace('The deposit field is required.', 'Monthly field is required.')); 
	
	});
	
	$('ul.errors li').each(function() {
		
    var text = $(this).text();
	
	
		
		$(this).text(text.replace('The price field is required.', 'Price field is required.')); 
	
	});
	
	
	$('ul.errors li').each(function() {
		
    var text = $(this).text();
	
		
		$(this).text(text.replace('The utilities included field is required.', 'We are having trouble finding that location pls add the correct complete address using google map.')); 
	
	});
	</script>	
@stop