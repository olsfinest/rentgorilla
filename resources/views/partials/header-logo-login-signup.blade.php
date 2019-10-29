<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
			<script>
			$(document).ready(function(){
				$('a').each(function(){
					this.href = this.href.replace('homestead.test', 'fcd232cd.ngrok.io');
				});
				
					$('#modify_rental_form').each(function(){
					this.action = this.action.replace('homestead.test', 'fcd232cd.ngrok.io');
				});
				
				
			});
			</script>
<header>
    <section class="main">
        <a title="RentGorilla... move on up." class="home" href="/">RentGorilla
            <span class="eyes" title="Did you know that gorillas blink approximately 30 times per minute? That's once every 2 seconds!">
                <span class="eye left"></span>
                <span class="eye right"></span>
            </span>
        </a>
        @if( ! Auth::check())
            <div class="user_actions">
                <button class="login">Login</button>
                <button class="sign_up">Sign Up</button>
            </div>
        @else
            @if(Session::has('revert'))
                <div id="revert_form">
                    {!! Form::open(['route' => 'admin.revert']) !!}
                        <button type="submit">Revert</button>
                    {!! Form::close() !!}
                </div>
            @endif
            <div class="avatar">
                @if($profilePhoto = Auth::user()->getProfilePhoto('small'))
                    <img src="{{ $profilePhoto }}" alt="">
                @else
                    <img src="/img/user.jpg" alt="">
                @endif
                <div class="avatar_actions">
                    <span class="user_name">{{ Auth::user()->getFullName() }} | <a href="/admin/subscription/plan#points">{{ Auth::user()->points }} Points</a></span>
                    <a href="{{ route('rental.index') }}"><span class="fa fa-dashboard"></span>My Dashboard</a>
                    <a href="{{ route('profile') }}" class="edit_profile"><span class="fa fa-user"></span>Edit Profile</a>
                    <a href="/logout" class="logout"><span class="fa fa-close"></span>Logout</a>
                </div>
                <span class="cf"></span>
            </div>
        @endif
    </section>
</header>