<ul class="hits">
@foreach($rentals as $rental)
    <li><a href="#">
            <img class="img-thumbnail pull-left" src="{{ $rental->photos->first()->name }}" />
            <p>{{ $rental->street_address }}
                <i>${{ $rental->price }}/month</i>
            </p>
        </a>
    </li>
@endforeach
</ul>