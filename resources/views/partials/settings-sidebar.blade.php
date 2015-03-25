<div class="list-group">
    @foreach($links as $link)
        <a href="{!! route($link['route']) !!}" class="list-group-item{!! $link['route'] == Route::currentRouteName() ? ' active' : '' !!}">{!! $link['text'] !!}</a>
    @endforeach
</div>