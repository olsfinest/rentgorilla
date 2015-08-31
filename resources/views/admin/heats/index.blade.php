@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Manage Heating Types</h1>

        <a class="button" href="{{ route('admin.heats.create') }}">Add a New Heating Type</a>

        @if($heats->count())
            <table>
                <tbody>
                <thead>
                <tr><th>Heating Type</th><th>Edit</th><th>Delete</th></tr>
        @foreach($heats as $heat)
            <tr><td>{{ $heat->name }}</td><td><a class="button" href="{{ route('admin.heats.edit', ['id' => $heat->id]) }}">Edit</a></td><td><a class="button" href="{{ route('admin.heats.delete', ['id' => $heat->id]) }}">Delete</a></td></tr>
        @endforeach
                </thead>
                </tbody>
            </table>
        @else
           <p>No heating types.</p>
        @endif
    </section>
@stop