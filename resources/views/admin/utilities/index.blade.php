@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Manage utilities</h1>

        <a class="button" href="{{ route('admin.utilities.create') }}">Add New utility</a>

        @if($utilities->count())
            <table>
                <thead>
                    <tr>
                        <th>utility</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($utilities as $utility)
                    <tr>
                        <td>{{ $utility->name }}</td>
                        <td><a class="button" href="{{ route('admin.utilities.edit', ['id' => $utility->id]) }}">Edit</a></td>
                        <td><a class="button" href="{{ route('admin.utilities.delete', ['id' => $utility->id]) }}">Delete</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
           <p>No utilities.</p>
        @endif
    </section>
@stop