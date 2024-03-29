<?php

$router->get('/', ['as' => 'home', 'uses' => 'AppController@showHome']);

/** Dynamic Sitemaps */

$router->get('sitemap', 'SitemapController@index');
$router->get('sitemap/pages', 'SitemapController@pages');
$router->get('sitemap/{location}', 'SitemapController@show');

/** Password resets */

Route::controllers([
    'password' => 'Auth\PasswordController',
]);

/** Authentication */

$router->get('logout', ['as' => 'logout', 'uses' => 'SessionController@logout']);
$router->get('login', ['as' => 'login', 'uses' => 'SessionController@showLogin']);
$router->post('login', ['as' => 'login', 'uses' => 'SessionController@login']);
$router->get('terms', ['as' => 'terms', 'uses' => 'AppController@showTerms']);

/** Social Authentication */

$router->get('login/{provider?}', 'SocialAuthController@redirectToProvider');
$router->get('login/{provider}/callback', 'SocialAuthController@handleProviderCallback');

/** Registration */
# AJAX
$router->post('register', ['as' => 'register', 'uses' => 'RegistrationController@register']);
$router->get('register/confirm/{token}', 'RegistrationController@confirm');
$router->post('reconfirm', ['as' => 'resend.confirmation', 'uses' => 'RegistrationController@resendConfirmation']);

/** Admin */
$router->post('admin/revert', ['as' => 'admin.revert', 'uses' => 'AdminController@revert']);
$router->get('admin/create-new-user', ['as' => 'admin.createNewUser', 'uses' => 'AdminController@showCreateNewUser']);
$router->post('admin/create-new-user', ['as' => 'admin.newUser', 'uses' => 'AdminController@newUser']);
$router->get('admin/search-users', ['as' => 'admin.searchUsers', 'uses' => 'AdminController@showSearchUsers']);
$router->post('admin/search-users', ['as' => 'searchUsers', 'uses' => 'AdminController@loginAsUser']);
$router->get('admin/send-activation', ['as' => 'admin.sendActivation', 'uses' => 'AdminController@showSendActivation']);
$router->post('admin/send-activation', ['as' => 'sendActivation', 'uses' => 'AdminController@sendActivation']);
$router->post('admin/edit-user-by-email', ['as' => 'admin.user.editUserByEmail', 'uses' => 'AdminController@editUserByEmail']);
$router->get('admin/user/{id}/delete', ['as' => 'admin.user.confirmDelete', 'uses' => 'AdminController@showDeleteUser']);
$router->get('admin/user/{id}/edit', ['as' => 'admin.user.edit', 'uses' => 'AdminController@showEditUser']);
$router->patch('admin/user/{id}', ['as' => 'admin.user.update', 'uses' => 'AdminController@updateUser']);
$router->delete('admin/user/{id}', ['as' => 'admin.user.destroy', 'uses' => 'AdminController@destroyUser']);

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

$router->get('admin/free-promotions/{rental_id}/cancel', ['as' => 'admin.free-promotions.confirm', 'uses' => 'AdminPromotionsController@confirmCancel']);
$router->post('admin/free-promotions/{rental_id}/cancel', ['as' => 'admin.free-promotions.cancel', 'uses' => 'AdminPromotionsController@cancel']);
$router->get('admin/free-promotions/{locationSlug?}', ['as' => 'admin.free-promotions.index', 'uses' => 'AdminPromotionsController@index']);
$router->post('admin/free-promotions', ['as' => 'admin.free-promotions.store', 'uses' => 'AdminPromotionsController@store']);
$router->post('admin/free-promotions/location/change', ['as' => 'admin.free-promotions.location', 'uses' => 'AdminPromotionsController@changeLocation']);
$router->post('admin/free-promotions/address-search/{locationSlug?}', ['as' => 'admin.free-promotions.location.search', 'uses' => 'AdminPromotionsController@searchAddress']);

$router->get('admin/redeem', ['as' => 'redeem.show', 'uses' => 'AchievementsController@showRedeemForm']);
$router->post('admin/redeem', ['as' => 'redeem.create', 'uses' => 'AchievementsController@redeemPoints']);
$router->get('admin/revenue', ['as' => 'admin.revenue', 'uses' => 'AdminController@revenue']);

Route::group(['prefix' => 'admin'], function () {
    Route::resource('safeties', 'SafetiesController');
    Route::resource('services', 'ServicesController');
    Route::resource('features', 'FeaturesController');
    Route::resource('heats', 'HeatsController');
    Route::resource('appliances', 'AppliancesController');
	Route::resource('utilities', 'UtilitiesController');
    Route::delete('locations/{locations}/landing-page/{landing_page}/slides/{name}', ['as' => 'admin.locations.landing-page.slides.destroy', 'uses' =>'LandingPageController@removeSlide']);;
    Route::get('locations/{locations}/landing-page/{landing_page}/slides', ['as' => 'admin.locations.landing-page.slides', 'uses' =>'LandingPageController@slides']);
    Route::post('locations/{locations}/landing-page/{landing_page}/slides', ['as' => 'admin.locations.landing-page.slides.create', 'uses' =>'LandingPageController@addSlide']);
    Route::resource('locations.landing-page', 'LandingPageController');
    Route::resource('locations', 'LocationsController');
});

$router->get('admin/areas', ['as' => 'admin.areas.index', 'uses' => 'AreasController@index']);
$router->post('admin/areas', ['as' => 'admin.areas.store', 'uses' => 'AreasController@store']);
$router->get('admin/areas/create', ['as' => 'admin.areas.create', 'uses' => 'AreasController@create']);
$router->get('admin/areas/{area}', ['as' => 'admin.areas.show', 'uses' => 'AreasController@show']);
$router->patch('admin/areas/{area}', ['as' => 'admin.areas.update', 'uses' => 'AreasController@update']);
$router->delete('admin/areas/{area}', ['as' => 'admin.areas.destroy', 'uses' => 'AreasController@destroy']);
$router->get('admin/areas/{area}/edit', ['as' => 'admin.areas.edit', 'uses' => 'AreasController@edit']);
$router->get('admin/areas/{area}/confirm-delete', ['as' => 'admin.areas.confirm-delete', 'uses' => 'AreasController@confirmDelete']);

$router->post('admin/slides/save-photo-order', ['as' => 'slide.photoOrder', 'uses' => 'LandingPageController@savePhotoOrder']);
$router->get('admin/slides/{slide_id}', ['as' => 'slide.edit', 'uses' => 'LandingPageController@editSlide']);
$router->get('admin/slides/{slide_id}/delete', ['as' => 'slide.confirm-delete', 'uses' => 'LandingPageController@confirmDeleteSlide']);
$router->patch('admin/slides/{slide_id}', ['as' => 'slide.update', 'uses' => 'LandingPageController@updateSlide']);

$router->get('admin/safeties/{safeties}/delete', ['as' => 'admin.safeties.delete', 'uses' => 'SafetiesController@delete']);
$router->get('admin/services/{services}/delete', ['as' => 'admin.services.delete', 'uses' => 'ServicesController@delete']);
$router->get('admin/features/{features}/delete', ['as' => 'admin.features.delete', 'uses' => 'FeaturesController@delete']);
$router->get('admin/heats/{heats}/delete', ['as' => 'admin.heats.delete', 'uses' => 'HeatsController@delete']);
$router->get('admin/utilities/{utilities}/delete', ['as' => 'admin.utilities.delete', 'uses' => 'UtilitiesController@delete']);
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
$router->post('address-search', 'AdminController@searchAddress');

$router->post('like', 'LikesController@toggleLike');

$router->post('landing-page/set-cookie', 'AppController@setLandingPageCookie');
$router->post('landing-page/delete-cookie', 'AppController@deleteLandingPageCookie');

$router->get('modify-availability/{rental}/{signature}', ['as' => 'signed.availability', 'uses' => 'Auth\SignedController@modifyAvailability']);

$router->get('rental/{rental}/availability', ['as' => 'rental.availability.edit', 'uses' => 'RentalController@editAvailability']);
$router->patch('rental/{rental}/availability', ['as' => 'rental.availability.update', 'uses' => 'RentalController@updateAvailability']);
$router->get('rental/{rental}/photos', ['as' => 'rental.photos.index', 'uses' => 'RentalController@showPhotos']);
$router->post('rental/{rental}/photos', ['as' => 'rental.photos.store', 'uses' => 'RentalController@addPhoto']);
$router->post('activate', ['as' => 'rental.activate', 'uses' => 'RentalController@toggleActivate']);
$router->post('rental/promote', ['as' => 'rental.promote', 'uses' => 'RentalController@promoteRental']);
$router->post('rental/promote/points/{rental}', ['as' => 'rental.promote.points', 'uses' => 'RentalController@promoteRentalWithPoints']);
$router->post('rental/phone', ['as' => 'rental.phone', 'uses' => 'RentalController@showPhone']);
$router->post('rental/email-manager', ['as' => 'rental.email', 'uses' => 'RentalController@sendManagerMail']);
$router->post('rental/show-video', ['as' => 'rental.video.show', 'uses' => 'VideoController@getEmbeddedVideo']);
$router->get('rental/{id}/delete', ['as' => 'rental.delete', 'uses' => 'RentalController@showDelete']);
$router->get('rental/{id}/reset', ['as' => 'rental.reset', 'uses' => 'RentalController@showReset']);

$router->post('rental/save-photo-order', ['as' => 'rental.photoOrder', 'uses' => 'RentalController@savePhotoOrder']);
$router->post('rental/like-video', 'VideoController@toggleLike');
$router->resource('rental', 'RentalController');

$router->resource('dashboard', 'RentalController');

$router->get('preview/{id}', ['as' => 'rental.preview', 'uses' => 'RentalController@showPreview']);

$router->delete('photo/{id}', ['as' => 'photos.delete', 'uses' => 'RentalController@deletePhoto']);
$router->get('photo/{id}', ['as' => 'photos.edit', 'uses' => 'RentalController@editPhoto']);
$router->patch('photo/{id}', ['as' => 'photos.rotate', 'uses' => 'RentalController@rotatePhoto']);

$router->post('favourite', 'FavouritesController@toggleFavourite');
$router->get('favourites', ['as' => 'favourites', 'uses' => 'FavouritesController@showFavourites']);

# Stripe webhook
$router->post('stripe/webhook', 'StripeWebhookController@handleWebhook');
$router->get('/{city?}', 'AppController@getCity');