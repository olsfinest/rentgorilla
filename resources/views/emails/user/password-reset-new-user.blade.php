@extends('emails.layouts.default')

@section('body')

    <p>Welcome To RentGorilla.ca!</p>

    <p>Please click the button below to enter your new password and take control of your account.</p>

    <p>Some things to keep in mind when adding your first property:</p>

    <ul>

        <li><strong>Provide Lots of Detail:</strong> Check to ensure property details are accurate, add and remove any features or appliances as you see fit. Keep in mind features receive a great deal of visibility in comparison to ‘Description’ text.</li>

        <li><strong>Monthly Rent:</strong> If you’re showing a ‘per room’ rate for rent, ensure you have selected ‘Room’ for your property type. Otherwise please use the full rent amount for the entire property if ‘House’ or ‘Apartment’ is selected. This helps folks understand if they need to gather roommates to go in on a home, or just commit to a single room.</li>

        <li><strong>Add Photos:</strong> If your property does not have a photo please work to add one, even if it is just the outside of the home. Listings with photos are much more likely to get attention.</li>
    </ul>

    <p>Something completely awesome:</p>

    <ul>
        <li><strong>Achievement Badges:</strong> We need detailed and timely information about you and your properties to help our propertu seekers. We also want to reward you for providing this information, in some cases every single month! To ‘achieve’ this we are offering badges. For example, when you fill out your profile completely you will get 500 points each month. Once you get 10,000 points, you can cash those in for $10 off any of our services while you maintain an active subscription. Note: Our achievement badges are awarded at midnight, so if you fill out your profile details, please await midnight to see that applied, you will also receive an email notification. Please note our points program is subject to change without notice or compensation and we reserve the right to deduct points for any unfair use or error in our system. Points have no redeemable cash value and cannot be transferred or sold.</li>
    </ul>

    <p>Thank you for your support and patience as we continue to improve the website.</p>

    @include('emails.user.partials.button', ['route' => url('password/reset/'.$token), 'title' => 'Set New Password'])

@stop