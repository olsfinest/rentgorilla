@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Manage Appliances</h1>

        <a class="button" href="{{ route('admin.appliances.create') }}">Add a New Appliance</a>

        @if($appliances->count())
            <table>
                <tbody>
                <thead>
                <tr><th>Appliance</th><th>Edit</th><th>Delete</th></tr>
        @foreach($appliances as $appliance)
            <tr><td>{{ $appliance->name }}</td><td><a class="button" href="{{ route('admin.appliances.edit', ['id' => $appliance->id]) }}">Edit</a></td><td><a class="button" href="{{ route('admin.appliances.delete', ['id' => $appliance->id]) }}">Delete</a></td></tr>
        @endforeach
                </thead>
                </tbody>
            </table>
        @else
           <p>No Appliances.</p>
        @endif
    </section>
@stop