@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Manage Features</h1>

        <a class="button" href="{{ route('admin.features.create') }}">Add New Feature</a>

        @if($features->count())
            <table>
                <tbody>
                <thead>
                <tr><th>Feature</th><th>Edit</th><th>Delete</th></tr>
        @foreach($features as $feature)
            <tr><td>{{ $feature->name }}</td><td><a class="button" href="{{ route('admin.features.edit', ['id' => $feature->id]) }}">Edit</a></td><td><a class="button" href="{{ route('admin.features.delete', ['id' => $feature->id]) }}">Delete</a></td></tr>
        @endforeach
                </thead>
                </tbody>
            </table>
        @else
           <p>No features.</p>
        @endif
    </section>
@stop