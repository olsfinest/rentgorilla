<?php namespace RentGorilla\Socialite;

class SocialiteManager extends \Laravel\Socialite\SocialiteManager
{
    /**
     * Create an instance of the specified driver.
     *
     * @return \Laravel\Socialite\Two\AbstractProvider
     */
    protected function createGoogleDriver()
    {
        $config = $this->app['config']['services.google'];

        return $this->buildProvider(
            'RentGorilla\Socialite\GoogleProvider', $config
        );
    }
}