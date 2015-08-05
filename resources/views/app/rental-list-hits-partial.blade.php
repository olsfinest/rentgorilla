@foreach($rentals as $rental)
    <li>
        @if($rental->isPromoted())
            <span class="promoted-small"></span>
        @endif
            <span id="{{ $rental->uuid }}" class="favourite fa {{ in_array($rental->id, $favourites) ? 'fa-heart' : 'fa-heart-o' }}"></span>
        <div class="images cycle-slideshow" data-cycle-fx="scrollHorz" data-cycle-speed="600" data-cycle-delay="0" data-cycle-timeout="1000">
            @if($rental->photos->count())
                @foreach($rental->photos as $photo)
                    <img src="{{ $photo->getSize('small') }}" alt="listing_image">
                @endforeach
            @else
                <img src="{{ getNoPhoto('small') }}" alt="listing_image">
            @endif
        </div>
        <span class="progress"></span>
        <span class="availability">Available: {!! $rental->available_at->format('M jS, Y') !!}</span>
        <ul class="listing_attributes">
            <li class="price">${!! $rental->price !!}</li>
            <li class="address"><a href="{{ route('rental.show', [$rental->uuid]) }}">{!! str_limit($rental->street_address, 20) !!}</a></li>
            <li class="description">{!! ucwords($rental->type) !!} - {!! $rental->beds !!} {!! $rental->beds == 1 ? 'Bed' : 'Beds' !!}</li>
        </ul>
    </li>
@endforeach