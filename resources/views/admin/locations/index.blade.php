@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css?v=2">
@stop
@section('content')
    <section class="content full admin">
        <h1>Locations and Landing Pages</h1>
        <a href="{{ route('admin.locations.create') }}" class="button">Create a New Location</a>
        @if($locations->count())
            <table>
                <thead><th>Location</th><th>Edit Location</th><th>Landing Page</th><th>Slides</th></thead>
                <tbody>
                    @foreach($locations as $location)
                        <tr>
                            <td>{{ $location->cityAndProvince() }}</td>
                            <td><a href="{{ route('admin.locations.edit', $location->id) }}" class="button">Edit</a></td>
                            @if(is_null($location->landing_page_id))
                                <td><a href="{{ route('admin.locations.landing-page.create', $location->id) }}" class="button">Create</a></td>
                                <td>&nbsp;</td>
                            @else
                                <td><a href="{{ route('admin.locations.landing-page.edit', [$location->id, $location->landing_page_id]) }}" class="button">Edit</a></td>
                                <td><a href="{{ route('admin.locations.landing-page.slides', [$location->id, $location->landing_page_id]) }}" class="button">Edit</a></td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination">
                {!! $locations->render() !!}
            </div>
        @else
            <p>No locations.</p>
        @endif
    </section>
@stop