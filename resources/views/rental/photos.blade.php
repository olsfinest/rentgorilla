@extends('layouts.admin')
@section('head')
    <script src="/js/dropzone.js" xmlns="http://www.w3.org/1999/html"></script>
    <link rel="stylesheet" href="/css/dropzone.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Photos for {{ $rental->street_address }}</h1>
        <p>You may drag and drop photos in the box below, or simply click within the box to choose photos to upload.</p>
        {!! Form::open(['route' => ['rental.photos.store', $rental->uuid], 'class' => 'dropzone', 'id' => 'myAwesomeDropzone']) !!}
{!! Form::close() !!}
@if($photoCount = $rental->photos()->count())
            <h1>Drag and drop photos to reorder</h1>
            <p>The order goes from left to right, with the top left being the first. Remember to save when you are finished reordering.</p>
    <ul id="items">
        @foreach($rental->photos as $photo)
            <li data-id="{{ $photo->name }}"><img src="{{ $photo->getSize('small') }}">
                {!! Form::open(['method' => 'DELETE', 'route' => ['photos.delete', $photo->name]]) !!}
                {!! Form::submit('Delete', ['class' => 'button']) !!}
                {!! Form::close() !!}
            </li>
        @endforeach
    </ul>
    <p>{{ $photoCount }} photo{{ $photoCount == 1 ? '' : 's' }}.</p>
    <a id="saveOrderBtn" class="button">Save Photo Order</a>
@endif
    <br><a href="{{ route('rental.index') }}" class="button">Back to Dashboard</a>
    </section>
@endsection
@section('footer')
        <script type="text/javascript" language="javascript" src="/js/Sortable.js"></script>
        <script type="text/javascript" language="javascript">

            var el = document.getElementById('items');
            var sortable = Sortable.create(el);

        $('#saveOrderBtn').on('click', function() {
            $.ajax({
                type: 'POST',
                url: '/rental/save-photo-order',
                data: {photoIds: sortable.toArray()},
                success: function (data, textStatus, jqXHR) {
                    showModal('Photo sort order has been saved!', '/rental', 'Back to Dashboard');
                }
            });
        });

        Dropzone.options.myAwesomeDropzone = {
            init: function() {
                this.on("queuecomplete", function (file) {
                    window.location.reload(true);
                });
            }
        };
    </script>
@endsection




