@foreach($rentals as $rental)
    <li>
        @if($rental->isPromoted())
            <span class="promoted-small"></span>
        @endif
        <span id="{{ $rental->uuid }}" class="favourite fa {{ in_array($rental->id, $favourites) ? 'fa-heart' : 'fa-heart-o' }}"></span>
        <a href="{{ route('rental.show', [$rental->uuid]) }}" title="Click to view details">
        <div class="images cycle-slideshow" data-cycle-fx="scrollHorz" data-cycle-speed="600" data-cycle-delay="0" data-cycle-timeout="1000">
            @if($rental->photos->count())
                @foreach($rental->photos as $photo)
                    <img width="237" height="158" src="{{ $photo->getSize('small') }}" alt="{{ $rental->street_address }}">
                @endforeach
            @else
                @foreach($noPhotos->shuffle() as $noPhoto)
                    <img width="237" height="158" src="{{ $noPhoto }}" alt="Sorry, no image available">
                @endforeach
            @endif
        </div>
        <span class="progress"></span>
        <span class="availability">Available: {!! $rental->available_at->format('M jS, Y') !!}</span>
        <ul class="listing_attributes">
            <li class="price">${!! $rental->price !!}</li>
            <li class="address">{!! str_limit($rental->street_address, 20) !!}</li>
            <li class="description">{!! ucwords($rental->type) !!} - {!! $rental->beds !!} {!! $rental->beds == 1 ? 'Bed' : 'Beds' !!}</li>
        </ul>
        </a>
    </li>
@endforeach