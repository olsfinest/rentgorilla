@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Manage Services</h1>

        <a class="button" href="{{ route('admin.services.create') }}">Add New Service</a>

        @if($services->count())
            <table>
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($services as $service)
                    <tr>
                        <td>{{ $service->name }}</td>
                        <td><a class="button" href="{{ route('admin.services.edit', ['id' => $service->id]) }}">Edit</a></td>
                        <td><a class="button" href="{{ route('admin.services.delete', ['id' => $service->id]) }}">Delete</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
           <p>No services.</p>
        @endif
    </section>
@stop