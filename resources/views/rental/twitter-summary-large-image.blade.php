@if($rental->photos()->count())
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@rentgorillaca">
<meta name="twitter:title" content="{{ $rental->street_address . ' ' . $rental->location->city . ', ' . Config::get('rentals.provinces.' . $rental->location->province) }} | RentGorilla.ca">
<meta name="twitter:description" content="{{ $rental->beds }} Bedroom / {{ (float) $rental->baths }} Bathroom {{ Config::get('rentals.type.' . $rental->type) }}">
<meta name="twitter:image" content="{{ url($rental->photos->first()->getSize('medium')) }}">
@endif