@if($rental->photos()->count())
<?php $title = $rental->street_address . ' ' . $rental->location->city . ', ' . Config::get('rentals.provinces.' . $rental->location->province); ?>
<?php $description = $rental->beds . ' Bedroom / ' . (float) $rental->baths . ' Bathroom ' .  Config::get('rentals.type.' . $rental->type); ?>
<?php $image = $rental->photos->first(); ?>
<?php $mediumImage = url($image->getSize('medium')); ?>
<?php $largeImage = url($image->getSize('large')); ?>
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@rentgorillaca">
<meta name="twitter:title" content="{{ $title }} | RentGorilla.ca">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $mediumImage }}">
<meta property="og:url" content="{{ route('rental.show', $rental->uuid) }}" />
<meta property="og:type" content="article" />
<meta property="og:title" content="{{ $title }}" />
<meta property="og:description" content="{{ $description }}" />
<meta property="og:site_name" content="RentGorilla" />
<meta property="og:image" content="{{ $largeImage }}" />
<meta property="og:image:url" content="{{ $largeImage }}" />
<meta property="og:image:secure_url" content="{{ $largeImage }}" />
<meta property="og:image:width" content="{{ \RentGorilla\Photo::LARGE_WIDTH }}" />
<meta property="og:image:height" content="{{ \RentGorilla\Photo::LARGE_HEIGHT }}" />
@endif