<?php

namespace Trexology\Contactable\Providers;

use Trexology\Contactable\Providers\ContactableAuthProvider;
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

        // Load views
        $this->loadViewsFrom(__DIR__.'/../../resources/views/', 'contactable');

        // Bind the authentication provider
        app()->bind('ContactableAuthProvider', function () {
            return new ContactableAuthProvider(app('hash'), config('auth.providers.users.model', \App\User::class));
        });

        // Add authentication driver
        Auth::provider('contactable', function($app) {
            // Return an instance of Illuminate\Contracts\Auth\UserProvider...
            return $app->make('ContactableAuthProvider');
        });
    }
}
