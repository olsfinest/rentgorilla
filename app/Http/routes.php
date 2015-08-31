<?php

$router->get('sitemap.xml', 'FeedsController@sitemap');

$router->get('/', ['as' => 'home', 'uses' => 'AppController@showHome']);

Route::controllers([
    'password' => 'Auth\PasswordController',
]);

/** Authentication */

$router->get('logout', ['as' => 'logout', 'uses' => 'SessionController@logout']);
$router->get('login', ['as' => 'login', 'uses' => 'SessionController@showLogin']);
$router->post('login', ['as' => 'login', 'uses' => 'SessionController@login']);


/** Social Authentication */

$router->get('login/{provider?}', 'SocialAuthController@redirectToProvider');
$router->get('login/{provider}/callback', 'SocialAuthController@handleProviderCallback');

/** Registration */
# AJAX
$router->post('register', ['as' => 'register', 'uses' => 'RegistrationController@register']);
$router->get('register/confirm/{token}', 'RegistrationController@confirm');
$router->post('reconfirm', ['as' => 'resend.confirmation', 'uses' => 'RegistrationController@resendConfirmation']);


/** Admin */

$router->get('admin/create-new-user', ['as' => 'admin.createNewUser', 'uses' => 'AdminController@showCreateNewUser']);
$router->post('admin/create-new-user', ['as' => 'admin.newUser', 'uses' => 'AdminController@newUser']);
$router->get('admin/search-users', ['as' => 'admin.searchUsers', 'uses' => 'AdminController@showSearchUsers']);
$router->post('admin/search-users', ['as' => 'searchUsers', 'uses' => 'AdminController@loginAsUser']);
$router->get('admin/send-activation', ['as' => 'admin.sendActivation', 'uses' => 'AdminController@showSendActivation']);
$router->post('admin/send-activation', ['as' => 'sendActivation', 'uses' => 'AdminController@sendActivation']);

/** Account settings */
$router->get('admin/settings', ['as' => 'settings.show', 'uses' => 'SettingsController@showSettings']);
$router->post('admin/settings', ['as' => 'settings.save', 'uses' => 'SettingsController@saveSettings']);

$router->get('admin/support', ['as' => 'support', 'uses' => 'SettingsController@showSupport']);
$router->post('admin/support', ['as' => 'contact.send', 'uses' => 'SettingsController@sendContact']);
$router->get('admin/profile', ['as' => 'profile', 'uses' => 'SettingsController@showProfile']);
$router->post('admin/profile', ['as' => 'profile.update', 'uses' => 'SettingsController@updateProfile']);
$router->get('admin/subscription/plan', ['as' => 'changePlan', 'uses' =>'SubscriptionController@showChangePlan']);
$router->get('admin/subscription/coupon', ['as' => 'applyCoupon', 'uses' => 'SubscriptionController@showApplyCoupon']);

$router->get('admin/subscription/invoices', ['as' => 'paymentHistory', 'uses' => 'SettingsController@showPaymentHistory']);
$router->get('admin/subscription/update', ['as' => 'updateCard', 'uses' => 'SettingsController@showUpdateCard']);
$router->get('admin/subscription/cancel', ['as' => 'cancelSubscription', 'uses' => 'SubscriptionController@showCancelSubscription']);
$router->get('admin/subscription/resume', ['as' => 'resumeSubscription', 'uses' => 'SubscriptionController@showResumeSubscription']);
$router->get('admin/subscription/swap/{plan_id}', ['as' => 'swapSubscription', 'uses' => 'SubscriptionController@showSwapSubscription']);

$router->get('admin/subscription/subscribe/{plan_id}', ['as' => 'showSubscribe', 'uses' => 'SubscriptionController@showSubscribe']);
$router->post('subscribe/{plan_id}', ['as' => 'subscribe', 'uses' => 'SubscriptionController@subscribe']);
$router->post('admin/subscription/coupon', ['as' => 'subscription.applyCoupon', 'uses' => 'SubscriptionController@applyCoupon']);
$router->post('admin/subscription/plan', ['as' => 'subscription.changePlan', 'uses' => 'SubscriptionController@changePlan']);
$router->get('admin/subscription/invoices/{id}', ['uses' => 'SettingsController@downloadInvoice']);
$router->post('admin/subscription/update', ['as' => 'subscription.updateCard', 'uses' => 'SubscriptionController@updateCard']);
$router->post('admin/subscription/cancel', ['as' => 'subscription.cancelSubscription', 'uses' => 'SubscriptionController@cancelSubscription']);
$router->post('admin/subscription/swap/{plan_id}', ['as' => 'subscription.swapSubscription', 'uses' => 'SubscriptionController@swapSubscription']);
$router->post('admin/subscription/resume', ['as' => 'subscription.resumeSubscription', 'uses' => 'SubscriptionController@resumeSubscription']);

$router->get('admin/promotions/{rental_id}', ['as' => 'promotions', 'uses' => 'RentalController@showPromotions']);
$router->get('admin/promotions/{rental_id}/cancel', ['as' => 'promotions.cancel', 'uses' => 'RentalController@showCancelPromotion']);
$router->delete('admin/promotions/{rental_id}', ['as' => 'promotions.delete', 'uses' => 'RentalController@cancelPromotion']);

$router->get('admin/redeem', ['as' => 'redeem.show', 'uses' => 'AchievementsController@showRedeemForm']);
$router->post('admin/redeem', ['as' => 'redeem.create', 'uses' => 'AchievementsController@redeemPoints']);

Route::group(['prefix' => 'admin'], function () {

    Route::resource('features', 'FeaturesController');
    Route::resource('heats', 'HeatsController');
    Route::resource('appliances', 'AppliancesController');
});

$router->get('admin/features/{features}/delete', ['as' => 'admin.features.delete', 'uses' => 'FeaturesController@delete']);
$router->get('admin/heats/{heats}/delete', ['as' => 'admin.heats.delete', 'uses' => 'HeatsController@delete']);
$router->get('admin/appliances/{appliances}/delete', ['as' => 'admin.appliances.delete', 'uses' => 'AppliancesController@delete']);


/** Application  */
$router->get('list/{slug?}', ['as' => 'list', 'uses' => 'AppController@showList']);
$router->get('map/{slug?}', ['as' => 'map', 'uses' =>'AppController@showMap']);
$router->post('clearSearch', ['as' => 'clearSearch', 'uses' => 'AppController@clearSearch']);

# AJAX
$router->get('rentals', 'AppController@getRentalList');
# AJAX
$router->get('markers', 'AppController@getMarkers');
# AJAX
$router->get('map-list', 'AppController@getRentalListForMap');
# AJAX
$router->get('location-list', 'AppController@getLocations');

$router->post('email-search', 'AdminController@searchUsers');

$router->post('like', 'LikesController@toggleLike');

$router->get('testing', function() {

   app('RentGorilla\Mailers\UserMailer')->sendTest(Auth::user());
    dd('done');
});

$router->resource('rental', 'RentalController');
$router->get('rental/{rental}/photos', ['as' => 'rental.photos.index', 'uses' => 'RentalController@showPhotos']);
$router->post('rental/{rental}/photos', ['as' => 'rental.photos.store', 'uses' => 'RentalController@addPhoto']);
$router->post('activate', ['as' => 'rental.activate', 'uses' => 'RentalController@toggleActivate']);
$router->post('rental/promote', ['as' => 'rental.promote', 'uses' => 'RentalController@promoteRental']);
$router->post('rental/phone', ['as' => 'rental.phone', 'uses' => 'RentalController@showPhone']);
$router->post('rental/email-manager', ['as' => 'rental.email', 'uses' => 'RentalController@sendManagerMail']);
$router->post('rental/show-video', ['as' => 'rental.video.show', 'uses' => 'VideoController@getEmbeddedVideo']);
$router->get('rental/{id}/delete', ['as' => 'rental.delete', 'uses' => 'RentalController@showDelete']);

$router->get('preview/{id}', ['as' => 'rental.preview', 'uses' => 'RentalController@showPreview']);

$router->delete('photo/{id}', ['as' => 'photos.delete', 'uses' => 'RentalController@deletePhoto']);

$router->post('rental/like-video', 'VideoController@toggleLike');


$router->post('favourite', 'FavouritesController@toggleFavourite');
$router->get('favourites', ['as' => 'favourites', 'uses' => 'FavouritesController@showFavourites']);


# Stripe webhook
$router->post('stripe/webhook', 'StripeWebhookController@handleWebhook');
$router->get('/{city?}', 'AppController@getCity');

