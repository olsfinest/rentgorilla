<?php namespace RentGorilla\Http\Controllers;

use RentGorilla\Http\Controllers\Controller;
use RentGorilla\User;
use Validator;
use Socialite;
use Auth;

class SocialAuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
     * Redirect the user to the provider authentication page.
     *
     * @param string $provider
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        if( ! config('services.' . $provider)) {
            return app()->abort(404);
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.
     *
     * @param string $provider
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        if ( ! config('services.' . $provider)) {
            return app()->abort(404);
        }

        $socialite = Socialite::driver($provider)->user();

        $user = User::where('email', $socialite->getEmail())->first();

        // there is an existing account, but you may still get authenticated by other providers if the account email matches
        // we also take the opportunity to update the users details

        if ($user) {

            switch ($user->provider) {

                case 'email':

                    return $this->logInUserAndRedirect($user, 'You have been logged in. You had previously registered via Email.');

                case 'facebook':

                    if($provider === 'facebook') {

                        $user = $this->updateSocialUser($user, $socialite->user['first_name'], $socialite->user['last_name'], $socialite->getEmail(), $socialite->getAvatar());
                    }

                    $this->logInUserAndRedirect($user, 'You have been logged in via Facebook');

                case 'google':

                    if($provider === 'google') {

                        $user = $this->updateSocialUser($user,$socialite->user['name']['givenName'], $socialite->user['name']['familyName'], $socialite->getEmail(), $socialite->getAvatar());

                    }

                    return $this->logInUserAndRedirect($user, 'You have been logged in via Google');

            }
        }

        // email wasn't in the system. They could have an existing social account though.
        // we have to test both facebook and twitter as they are both numerical ids.
        // Extremely rare that they would have the same id! But hey, we'll test it anyway!

        $user = User::where(['provider_id' => $socialite->getId(), 'provider' => 'facebook'])->first();

        if($user) {

            $user = $this->updateSocialUser($user, $socialite->user['first_name'], $socialite->user['last_name'], $socialite->getEmail(), $socialite->getAvatar());

            return $this->logInUserAndRedirect($user, 'You have been logged in via Facebook');

        }

        $user = User::where(['provider_id' => $socialite->getId(), 'provider' => 'google'])->first();

        if($user) {

            $user = $this->updateSocialUser($user, $socialite->user['name']['givenName'], $socialite->user['name']['familyName'], $socialite->getEmail(), $socialite->getAvatar());

            return $this->logInUserAndRedirect($user, 'You have been logged in via Google');

        }

        // no social account found, I'm going to need you to go ahead and create a new social user, that'd be great

        if($provider === 'facebook') {

            $user = $this->createSocialUser('facebook', $socialite->getId(), $socialite->user['first_name'], $socialite->user['last_name'], $socialite->getEmail(), $socialite->getAvatar());

            return $this->logInUserAndRedirect($user, 'Success! You now have a new account via Facebook!');

        }

        if($provider === 'google') {

            $user = $this->createSocialUser('google', $socialite->getId(), $socialite->user['name']['givenName'], $socialite->user['name']['familyName'], $socialite->getEmail(), $socialite->getAvatar());

            return $this->logInUserAndRedirect($user, 'Success! You now have a new account via Google!');

        }

    }

    private function logInUserAndRedirect($user, $message = null)
    {

        Auth::login($user, true);

        if($message) return redirect('/')->with('flash:success', $message);

        return redirect('/');
    }

    private function updateSocialUser($user, $firstName, $lastName, $email, $avatar)
    {
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->email = $email;
        $user->avatar = $avatar;
        $user->save();

        return $user;
    }

    private function createSocialUser($provider, $providerId, $firstName, $lastName, $email, $avatar)
    {
        $user = new User();

        $user->provider = $provider;
        $user->provider_id = $providerId;
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->email = $email;
        $user->avatar = $avatar;
        $user->save();

        return $user;
    }

}