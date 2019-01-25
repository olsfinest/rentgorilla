@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css?v=2">
@stop
@section('content')
    <section class="content full admin">
        <h1>All Areas</h1>
        <a href="{{ route('admin.locations.index') }}" class="button">List All Locations</a>
        <a href="{{ route('admin.areas.create') }}" class="button">Create a New Area</a>
        @if($areas->count())
            <table>
                <thead><th>Name</th><th>Province</th><th>View Area</th><th>Edit Area</th><th>Delete Area</th></thead>
                <tbody>
                @foreach($areas as $area)
                    <tr>
                        <td>{{ $area->name }}</td>
                        <td>{{ $area->province }}</td>
                        <td><a href="{{ route('admin.areas.show', $area->id) }}" class="button">View</a></td>
                        <td><a href="{{ route('admin.areas.edit', $area->id) }}" class="button">Edit</a></td>
                        <td><a href="{{ route('admin.areas.confirm-delete', $area->id) }}" class="button">Delete</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="pagination">
                {!! $areas->render() !!}
            </div>
        @else
            <p>No areas.</p>
        @endif
    </section>
@stop