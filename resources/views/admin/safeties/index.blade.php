@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css">
@stop
@section('content')
    <section class="content full admin">
        <h1>Manage Safety and Security Items</h1>

        <a class="button" href="{{ route('admin.safeties.create') }}">Create a New Safety and Security Item</a>

        @if($safeties->count())
            <table>
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($safeties as $safety)
                    <tr>
                        <td>{{ $safety->name }}</td>
                        <td><a class="button" href="{{ route('admin.safeties.edit', ['id' => $safety->id]) }}">Edit</a></td>
                        <td><a class="button" href="{{ route('admin.safeties.delete', ['id' => $safety->id]) }}">Delete</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
           <p>No safety and security items.</p>
        @endif
    </section>
@stop