[![Latest Stable Version](https://poser.pugx.org/trexology/contactable/v/stable)](https://packagist.org/packages/trexology/contactable)
[![Total Downloads](https://poser.pugx.org/trexology/contactable/downloads)](https://packagist.org/packages/trexology/contactable)
[![Latest Unstable Version](https://poser.pugx.org/trexology/contactable/v/unstable)](https://packagist.org/packages/trexology/contactable) [![License](https://poser.pugx.org/trexology/contactable/license)](https://packagist.org/packages/trexology/contactable)

# Contactable

A [Laravel 5.2+](http://laravel.com/docs/5.2) package designed to enhance Eloquent users (or any other model) with relations to
multiple e-mail addresses and phone numbers, additionally allowing users to login with any of the above.

```js
composer require trexology/contactable
```

And then include the service provider within `app/config/app.php`. (not required for laravel 5.4+)

```php
'providers' => [
    Trexology\Contactable\PointableServiceProvider::class
];
```

At last you need to publish and run the migration.
```
php artisan vendor:publish --provider="Trexology\Contactable\Providers\ContactableServiceProvider" && php artisan migrate
```

This will add addresses, email_addresses and phone_numbers tables to your database.

Remove the email column from your create_users_table table migration, if applicable.
