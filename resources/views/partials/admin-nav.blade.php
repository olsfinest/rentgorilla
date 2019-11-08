<section class="admin_nav">
    <a title="Show / Hide Menu" href="#" onclick="return false;" class="admin_nav_toggle"><i class="fa fa-bars"></i></a>
    <ul>
        <li class="fa fa-dashboard"><a href={{ route('dashboard.index') }}>Dashboard</a></li>
        <li class="fa fa-heart"><a href="{{ route('favourites') }}">Favourites</a></li>
        <li class="fa fa-credit-card">
            <a href="#">Billing</a>
            <ul>
                <li><a href="{{ route('changePlan') }}">Subscription</a></li>
                <li><a href="{{ route('paymentHistory') }}">Payment History</a></li>
                <li><a href="{{ route('updateCard') }}">Credit Card</a></li>
                <li><a href="{{ route('applyCoupon') }}">Coupon</a></li>
                <li><a href="{{ route('redeem.show') }}">Redeem Points</a></li>
            </ul>
        </li>
        <li class="fa fa-user">
            <a href="#">Account</a>
            <ul>
                <li><a href="{{ route('profile') }}">Edit Profile</a></li>
                <li><a href="{{ route('settings.show') }}">Manage Settings</a></li>
            </ul>
        </li>
        <li class="fa fa-comments"><a href="{{ route('support') }}">Support</a></li>
        @if(Auth::user()->isAdmin())
            <li class="fa fa-users">
            <a href="#">Admin</a>
            <ul>
                <li><a href="{{ route('admin.createNewUser') }}">Create New User</a></li>
                <li><a href="{{ route('admin.searchUsers') }}">Search Users</a></li>
                <li><a href="{{ route('admin.sendActivation') }}">Send Activation Email</a></li>
                <li><a href="{{ route('admin.safeties.index') }}">Manage Safety and Security</a></li>
                <li><a href="{{ route('admin.services.index') }}">Manage Services</a></li>
                <li><a href="{{ route('admin.features.index') }}">Manage Features</a></li>
                <li><a href="{{ route('admin.heats.index') }}">Manage Heating</a></li>
                <li><a href="{{ route('admin.appliances.index') }}">Manage Appliances</a></li>
				<li><a href="{{ route('admin.utilities.index') }}">Manage Utilities</a></li>
                <li><a href="{{ route('admin.locations.index') }}">Landing Pages</a></li>
                <li><a href="{{ route('admin.free-promotions.index') }}">Promotions</a></li>
                <li><a href="{{ route('admin.revenue') }}">Subscription Revenue</a></li>
            </ul>
            </li>
            <li><a href="{{ route('admin.searchUsers') }}">Search Users</a></li>
        @endif
    </ul>
</section>