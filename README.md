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

 ## Usage

For any models you would like to have their own phone numbers or e-mail addresses, add the appropriate trait:

- use `Addressable`;
- use `Phonable`;
- use `Emailable`;

…or use the `Contactable` trait to quickly add addresses, phones and e-mails:

use `Contactable`;

The above traits simply add the appropriate relationships to your model. Now, you may query the relationships using Eloquent as you normally would.

**E-mail addresses** are accessed via the “emails()” method (a MorphMany relationship):
```
<?php

// Add an e-mail address to a new model
$model = new Model;
$model->emails()->save(new \GridPrinciples\Contactable\EmailAddress(['address' => 'zero@example.com']));

// Add multiple e-mail addresses to a pre-existing model
$model = Model::find(1);
$model->emails()->saveMany([
    new \GridPrinciples\Contactable\EmailAddress(['address' => 'one@example.com']),
    new \GridPrinciples\Contactable\EmailAddress(['address' => 'two@example.com']),
]);


// Query records which have at least two e-mail addresses
Model::has('emails', '>=', 2)->get();

// Query records which have a specific e-mail address
$address = 'three@example.com';
Model::whereHas('emails', function ($query) use ($address) {
    $query->where('address', '=', $address);
});
```

**Phone numbers** are accessed via the “phones()” method (a MorphMany relationship):

```
<?php

// Add a phone number to a new model
$model = new Model;
$model->phones()->save(new \GridPrinciples\Contactable\PhoneNumber(['number' => '123 4567']));

// Add multiple phone numbers to a pre-existing model
$model = Model::find(1);
$model->phones()->saveMany([
    new \GridPrinciples\Contactable\PhoneNumber(['number' => '(234) 567-8900']),
    new \GridPrinciples\Contactable\PhoneNumber(['number' => '2222222']),
]);

// Query records which have at least two phone numbers
Model::has('phones', '>=', 2)->get();

// Query records which have a specific phone number
$number = '(000) 011-0000';
Model::whereHas('phones', function ($query) use ($number) {
    $query->where('raw_number', '=', preg_replace("/[^0-9]/", '', $number)); // query only the numbers
});
```
