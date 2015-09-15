{!! Form::open(['route' => 'clearSearch', 'id' => 'search']) !!}
    <label for="location">
        <select name="location" id="location" style="width: 200px;">
            @if($location)
                <option value="{{ $location }}" selected="selected">{{ getCityAndProvince($location) }}</option>
            @elseif(Session::has('location'))
                <option value="{{ Session::get('location') }}" selected="selected">{{ getCityAndProvince(Session::get('location')) }}</option>
            @endif
        </select>
    </label>
    @foreach($searchOptions as $name => $list)
        <label for="{{ $name }}" class="arrows">
            {!! Form::select($name, $list, Session::get($name), ['class' => 'selectmenu']) !!}
        </label>
    @endforeach
    <button type="submit">Clear All</button>
    <img id="spinner" src="/img/ajax-loader.gif">
    <div class="view_switcher">
        View 
        <select class="selectmenu" name="" id="" onchange="if (this.value) window.location.href=this.value">
            <option value="/list">List</option>
            <option value="/map">Map</option>
        </select>
    </div>
{!! Form::close() !!}