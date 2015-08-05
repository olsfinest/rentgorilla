@if( ! is_null($video['player']))
    <div>{!! $video['player'] !!}</div>
    <div><span id="toggleVideoLike" class="fa {{ $liked ? 'fa-thumbs-up' : 'fa-thumbs-o-up' }}"> {{ $video['likes'] }}</span></div>
@else
    @if( ! is_null($video['link']))
        <div>Sorry, we couldn't resolve a player for this video.</div>
        <div><a href="{{ $video['link'] }}">{{ $video['link'] }}</a></div>
    @endif
@endif