{!! Form::open(['route' => 'clearSearch', 'id' => 'search']) !!}
    <label for="location">
        <select name="location" id="location" style="width: 200px;">
            @if(Session::has('location'))
                <option value="{{ Session::get('location') }}" selected="selected">{{ Session::get('location') }}</option>
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
{!! Form::close() !!}