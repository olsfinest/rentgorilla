<ul class="hits">
@foreach($rentals as $rental)
    <li>
        @if($rental->isPromoted())
            <span class="promoted-small"></span>
        @endif
        <a href="{{ route('rental.show', [$rental->uuid]) }}">
            @if($rental->photos->count())
                <img class="img-thumbnail pull-left" src="{{ $rental->photos->first()->getSize('small') }}" />
            @else
                <img class="img-thumbnail pull-left" src="{{ getNoPhoto('small') }}" />
            @endif
            <p>{{ $rental->street_address }}
                <i>${{ $rental->price }}/month</i>
            </p>
        </a>
    </li>
@endforeach
</ul>