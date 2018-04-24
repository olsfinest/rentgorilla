@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="/css/form.css?v=2">
@stop
@section('content')
    <section class="content full admin">
        <h1>Create Landing Page for Location: {{ $location->cityAndProvince() }}</h1>
        <a href="{{ route('admin.locations.index') }}" class="button">List All Locations</a>

        @include('errors.error-list')

        {!! Form::open(['route' => ['admin.locations.landing-page.store', $location->id]]) !!}

        <label>Community Name
            {!! Form::text('name', $location->city) !!}
        </label>

        @include('admin.landing-pages.form')

        <label>Community links</label>
        <label class="half left"><a href="javascript:void(0);" class="button addLink"><i class="fa fa-plus-square"></i> Add a link</a></label>
        <br class="cf"></br>
        <div id="links">
            <?php
                $hrefsCount = old('hrefs') ? count(old('hrefs')) : 0;
                $titlesCount = old('titles') ? count(old('titles')) : 0;
                $count = max($hrefsCount, $titlesCount);
                ?>
            @if($count)
                @for ($i = 0; $i < $count; $i++)
                    <div class="linkGroup">
                        <label class="half left">Link:<input type="text" name="hrefs[]" value="{{ old('hrefs.' . $i) }}"></label>
                        <label class="half right">Title:<input type="text" name="titles[]" value="{{ old('titles.' . $i)}}"></label>
                        <label class="half left"><a href="javascript:void(0);" class="button removeLink"><i class="fa fa-minus-square"></i> Remove link</a></label>
                    </div>
                @endfor
            @endif
        </div>
        <br class="cf"></br>

        {!! Form::submit('Create Landing Page') !!}

        {!! Form::close() !!}

    </section>
@stop
@section('footer')
    <script language="JavaScript" type="text/javascript">

        $( document ).ready(function() {

            $('.removeLink').on('click', function () {
                $(this).closest('div').remove();
            });

            $('.addLink').on('click', function () {

                $('#links').append('<div class="linkGroup">' +
                        '<label class="half left">Link:<input type="text" name="hrefs[]"></label>' +
                        '<label class="half right">Title:<input type="text" name="titles[]"></label>' +
                        '<label class="half left"><a href="javascript:void(0);" class="button removeLink"><i class="fa fa-minus-square"></i> Remove link</a></label>' +
                        '</div>');

                $('.removeLink').on('click', function () {
                    $(this).closest('div').remove();
                });
            });
        });
    </script>
@stop