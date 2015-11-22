@extends('layouts.admin')
@section('head')
    <script src="/js/dropzone.js" xmlns="http://www.w3.org/1999/html"></script>
    <link rel="stylesheet" href="/css/dropzone.css">
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Slides for Landing Page for Location: {{ $location->cityAndProvince() }}</h1>
        <a href="{{ route('admin.locations.index') }}" class="button">List All Locations</a>
        <br>
        <p>You may drag and drop photos in the box below, or simply click within the box to choose photos to upload.</p>
        <p>Upload only <strong>{{ \RentGorilla\Slide::MAX_COUNT }}</strong> slides.</p>
        {!! Form::open(['route' => ['admin.locations.landing-page.slides.create', $location->id, $location->landingPage->id], 'class' => 'dropzone', 'id' => 'myAwesomeDropzone']) !!}
        {!! Form::close() !!}
        @if($photoCount = $location->landingPage->slides()->count())
            <h1>Drag and drop photos to reorder</h1>
            <p>The order goes from left to right, with the top left being the first. Remember to save when you are finished reordering.</p>
            <ul id="items">
                @foreach($location->landingPage->slides as $slide)
                    <li data-id="{{ $slide->name }}"><img src="/img/slides/{{ $slide->name }}"><br>
                        <a href="{{ route('slide.edit', $slide->id) }}" class="button">Edit</a>
                        <a href="{{ route('slide.confirm-delete', $slide->id) }}" class="button">Delete</a>
                    </li>
                @endforeach
            </ul>
            <p>{{ $photoCount }} slide{{ $photoCount == 1 ? '' : 's' }}.</p>
            <a id="saveOrderBtn" class="button">Save Photo Order</a>
        @endif
    </section>
@stop

@section('footer')
    <script type="text/javascript" language="javascript" src="/js/Sortable.js"></script>
    <script type="text/javascript" language="javascript">

        var el = document.getElementById('items');
        var sortable = Sortable.create(el);

        $('#saveOrderBtn').on('click', function() {
            $.ajax({
                type: 'POST',
                url: '/slides/save-photo-order',
                data: {photoIds: sortable.toArray()},
                success: function (data, textStatus, jqXHR) {
                    showModal('Photo sort order has been saved!', '{{ route('admin.locations.index')  }}', 'Back to Locations and Landing Pages');
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