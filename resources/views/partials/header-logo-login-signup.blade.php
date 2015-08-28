<header>
    <section class="main">
        <a title="RentGorilla... move on up." class="home" href="/">RentGorilla<small>Move on up</small>
            <span class="eyes" title="Did you know that gorillas blink approximately 30 times per minute? That's once every 2 seconds!">
                <span class="eye left"></span>
                <span class="eye right"></span>
            </span>
        </a>
         @if( ! Auth::check())
            <div class="user_actions">
                <button class="login">Login</button>
                <button class="sign_up">Sign up</button>
                </div>
            @else
                <div class="avatar">
                    @if( ! is_null(Auth::user()->profile) && ! is_null(Auth::user()->profile->photo))
                        <img src="/img/profiles/{{ Auth::user()->profile->photo}}" alt="">
                    @else
                        <img src="/img/user.jpg" alt="">
                    @endif
                    <div class="avatar_actions">
                        <span class="user_name">{{ Auth::user()->getFullName() }}</span>
                        <a href="{{ route('rental.index') }}"><span class="fa fa-dashboard"></span>My Dashboard</a>
                        <a href="{{ route('profile') }}" class="edit_profile"><span class="fa fa-user"></span>Edit Profile</a>
                        <a href="/logout" class="logout"><span class="fa fa-close"></span>Logout</a>
                    </div>
                    <span class="cf"></span>
                </div>
            @endif
    </section>
</header>