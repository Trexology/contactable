<?php

namespace GridPrinciples\Party\Providers;

use GridPrinciples\Party\Providers\ContactableAuthProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class ContactableServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/contactable.php', 'contactable'
        );
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish configuration
        $this->publishes([
            __DIR__.'/../../config/contactable.php' => config_path('contactable.php'),
        ], 'config');

        // Publish migrations
        $this->publishes([
            __DIR__.'/../Migrations/' => database_path('migrations')
        ], 'migrations');

        // Add authentication driver
        Auth::extend('contactable', function() {
            // Return an instance of Illuminate\Contracts\Auth\UserProvider...
            return new ContactableAuthProvider(app('hash'), '\App\User');
        });
    }
}
