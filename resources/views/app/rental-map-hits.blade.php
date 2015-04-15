<ul class="hits">
@foreach($rentals as $rental)
    <li><a href="{{ route('rental.show', [$rental->uuid]) }}">
            @if($rental->photos->count())
                <img class="img-thumbnail pull-left" src="{{ $rental->photos->first()->name }}" />
            @else
                <img class="img-thumbnail pull-left" src="/img/default-img.jpg" />
            @endif
            <p>{{ $rental->street_address }}
                <i>${{ $rental->price }}/month</i>
            </p>
        </a>
    </li>
@endforeach
</ul>