{!! Form::open(['route' => 'clearSearch', 'id' => 'search']) !!}
    <label for="location">
        <select autocomplete="off" name="location" id="location" style="width: 200px;">
            @if($location)
                <option value="{{ $location }}" selected="selected">{{ getCityAndProvince($location) }}</option>
            @elseif(Session::has('location'))
                <option value="{{ Session::get('location') }}" selected="selected">{{ getCityAndProvince(Session::get('location')) }}</option>
            @endif
        </select>
    </label>
    @foreach($searchOptions as $name => $list)
        <label for="{{ $name }}" class="arrows">
            {!! Form::select($name, $list, Request::has($name) ? Request::get($name) : Session::get($name), ['autocomplete' => 'off', 'class' => 'selectmenu']) !!}
        </label>
    @endforeach
        {!! Form::hidden('sort', Request::has('sort') ? Request::get('sort') : Session::get('sort'), ['id' => 'sortField']) !!}
    <button type="submit">Clear</button>
    <img id="spinner" src="/img/ajax-loader.gif">
{!! Form::close() !!}
    <div class="view_switcher">
        <select autocomplete="off" class="options" name="" id="">
            <option value="/list/{{$location}}" {{ (Request::is('list') || Request::is('list/*')) ? 'selected' : '' }}>List View</option>
            <option value="/map/{{$location}}" {{ (Request::is('map') || Request::is('map/*')) ? 'selected' : '' }}>Map View</option>
        </select>
    </div>