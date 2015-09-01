@extends('emails.layouts.default')

@section('body')

    <p>Welcome To RentGorilla.ca!</p>

    <p>Please click the button below to enter your new password and take control of your account.</p>

    <p>Some things to keep in mind:</p>

    <ul>
        <li><strong>Imported Listings:</strong> We have imported most of your listings from RentAntigonish.ca. If your listing was not imported please recreate it.</li>

        <li><strong>Date Available:</strong> Check to ensure your date of availability is accurate. We have advanced all past availability dates to one year in the future. Even if your property is currently rented we recommend advancing the availability date into the future so you can get your pick of the best renters. This is also a great time to experiment with a higher rental rate, which can also be lowered as you get closer to your availability date.</li>

        <li><strong>Property Details, Features, Appliances etc:</strong> Check to ensure property details are accurate, add and remove any features or appliances as you see fit. Keep in mind features receive a great deal of visibility in comparison to ‘Description’ text.</li>

        <li><strong>Monthly Rent:</strong> If you’re showing a ‘per room’ rate for rent, ensure you have selected ‘Room’ for your property type. Otherwise please use the full rent amount for the entire property if ‘House’ or ‘Apartment’ is selected. This helps folks understand if they need to gather roommates to go in on a home, or just commit to a single room.</li>

        <li><strong>Add Photos:</strong> If your property does not have a photo please work to add one, even if it is just the outside of the home. Listings with photos are twice as likely to get attention.</li>
    </ul>

    <p>Something completely awesome:</p>

    <ul>
        <li><strong>Achievement Badges:</strong> We need detailed and timely information about you and your properties to help our users. We also want to reward you for providing this, in some cases every single month. To ‘achieve’ this we are offering badges. For example, fill out your profile, and you will get 500 points each month. Once your get 10,000 points, you can cash those in for $10 off any of our services with a subscription.  This is one of the most exciting changes we have implemented and we hope to add more Badges in the near future. Note: Our badges are awarded at midnight, so if you fill out your profile details, please await midnight to see that applied, you will also receive an email notification.</li>
    </ul>

    <p>Thank you for your support and patience as we continue to improve the website.</p>

    @include('emails.user.partials.button', ['route' => url('password/reset/'.$token), 'title' => 'Set New Password'])

@stop