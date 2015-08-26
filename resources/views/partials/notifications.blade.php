@if(Session::has('flash:success') || Session::has('flash:warning') || Session::has('flash:error'))
    <ul class="toaster">
        @if(Session::has('flash:success'))
            <li class="toast fadeMe">
                <p>{{ Session::get('flash:success') }}</p>
                <span class="fa fa-close" title="Hide the notification"></span>
            </li>
        @endif
        @if(Session::has('flash:warning'))
            <li class="toastWarning">
                <p>{{ Session::get('flash:warning') }}</p>
                <span class="fa fa-close" title="Hide the notification"></span>
            </li>
        @endif
        @if(Session::has('flash:error'))
            <li class="toastError">
                <p>{{ Session::get('flash:error') }}</p>
            <span class="fa fa-close" title="Hide the notification"></span>
        </li>
        @endif
    </ul>
@endif