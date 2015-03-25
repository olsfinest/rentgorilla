<?php

//Auth::loginUsingId(1);

$router->get('/', ['as' => 'home', 'uses' => 'AppController@showHome']);


/** Authentication */

$router->get('logout', ['as' => 'logout', 'uses' => 'SessionController@logout']);
$router->get('login', ['as' => 'login', 'uses' => 'SessionController@showLogin']);
$router->post('login', ['as' => 'login', 'uses' => 'SessionController@login']);

/** Registration */
# AJAX
$router->post('register', ['as' => 'register', 'uses' => 'RegistrationController@register']);
$router->get('register/confirm/{token}', 'RegistrationController@confirm');
$router->post('reconfirm', ['as' => 'resend.confirmation', 'uses' => 'RegistrationController@resendConfirmation']);

/** Account settings */
$router->get('admin/profile', ['as' => 'profile', 'uses' => 'SettingsController@showProfile']);
$router->post('admin/profile', ['as' => 'profile.update', 'uses' => 'SettingsController@updateProfile']);
$router->get('admin/subscription/plan', ['as' => 'changePlan', 'uses' =>'SettingsController@showChangePlan']);
$router->get('admin/subscription/coupon', ['as' => 'applyCoupon', 'uses' => 'SettingsController@showApplyCoupon']);
$router->get('admin/subscription/invoices', ['as' => 'paymentHistory', 'uses' => 'SettingsController@showPaymentHistory']);
$router->get('admin/subscription/update', ['as' => 'updateCard', 'uses' => 'SettingsController@showUpdateCard']);
$router->get('admin/subscription/cancel', ['as' => 'cancelSubscription', 'uses' => 'SettingsController@showCancelSubscription']);

/** Application  */
$router->get('list', ['as' => 'list', 'uses' => 'AppController@showList']);
$router->get('map', ['as' => 'map', 'uses' =>'AppController@showMap']);
$router->post('clearSearch', ['as' => 'clearSearch', 'uses' => 'AppController@clearSearch']);

# AJAX
$router->get('rentals', 'AppController@getRentalList');
# AJAX
$router->get('markers', 'AppController@getMarkers');
# AJAX
$router->get('map-list', 'AppController@getRentalListForMap');
# AJAX
$router->get('location-list', 'AppController@getLocations');

$router->get('testing', function() {
   throw new \Illuminate\Session\TokenMismatchException();
});

$router->resource('rental', 'RentalController');
$router->get('rental/{rental}/photos', ['as' => 'rental.photos.index', 'uses' => 'RentalController@showPhotos']);
$router->post('rental/{rental}/photos', ['as' => 'rental.photos.store', 'uses' => 'RentalController@addPhoto']);
$router->post('activate', ['as' => 'rental.activate', 'uses' => 'RentalController@toggleActivate']);

$router->post('favourite', 'FavouritesController@toggleFavourite');
$router->get('favourites', ['as' => 'favourites', 'uses' => 'FavouritesController@showFavourites']);
$router->delete('favourites/{rental}', ['as' => 'favourites.delete', 'uses' => 'FavouritesController@removeFavourite']);
