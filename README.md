[![Latest Stable Version](https://poser.pugx.org/trexology/contactable/v/stable)](https://packagist.org/packages/trexology/contactable)
[![Total Downloads](https://poser.pugx.org/trexology/contactable/downloads)](https://packagist.org/packages/trexology/contactable)
[![Latest Unstable Version](https://poser.pugx.org/trexology/contactable/v/unstable)](https://packagist.org/packages/trexology/contactable) [![License](https://poser.pugx.org/trexology/contactable/license)](https://packagist.org/packages/trexology/contactable)

# Contactable

A [Laravel 5.2+](http://laravel.com/docs/5.2) package designed to enhance Eloquent users (or any other model) with relations to
multiple e-mail addresses and addresses, additionally allowing users to login with any of the above.

```js
composer require trexology/contactable
```

And then include the service provider within `app/config/app.php`. (not required for laravel 5.5+)

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

For any models you would like to have their own addresses or e-mail addresses, add the appropriate trait:

```
use Trexology\Contactable\Traits\Addressable;
use Trexology\Contactable\Traits\Phonable;
use Trexology\Contactable\Traits\Emailable;

class User extends Authenticatable implements
{
    use Addressable, Phonable, Emailable;
```

…or use the `Contactable` trait to quickly add addresses, phones and e-mails:

```
use Trexology\Contactable\Traits\Contactable;

class User extends Authenticatable implements
{
    use Contactable;
```

The above traits simply add the appropriate relationships to your model. Now, you may query the relationships using Eloquent as you normally would.

**E-mail addresses** are accessed via the “emails()” method (a MorphMany relationship):
```
<?php

// Add an e-mail address to a new model
$model = new Model;
$model->emails()->save(new \Trexology\Contactable\EmailAddress(['address' => 'zero@example.com']));

// Add multiple e-mail addresses to a pre-existing model
$model = Model::find(1);
$model->emails()->saveMany([
    new \Trexology\Contactable\EmailAddress(['address' => 'one@example.com']),
    new \Trexology\Contactable\EmailAddress(['address' => 'two@example.com']),
]);


// Query records which have at least two e-mail addresses
Model::has('emails', '>=', 2)->get();

// Query records which have a specific e-mail address
$address = 'three@example.com';
Model::whereHas('emails', function ($query) use ($address) {
    $query->where('address', '=', $address);
});
```

**Phone** are accessed via the “phones()” method (a MorphMany relationship):

```
<?php

// Add a phone number to a new model
$model = new Model;
$model->phones()->save(new \Trexology\Contactable\PhoneNumber(['number' => '123 4567']));

// Add multiple addresses to a pre-existing model
$model = Model::find(1);
$model->phones()->saveMany([
    new \Trexology\Contactable\PhoneNumber(['number' => '(234) 567-8900']),
    new \Trexology\Contactable\PhoneNumber(['number' => '2222222']),
]);

// Query records which have at least two addresses
Model::has('phones', '>=', 2)->get();

// Query records which have a specific phone number
$number = '(000) 011-0000';
Model::whereHas('phones', function ($query) use ($number) {
    $query->where('raw_number', '=', preg_replace("/[^0-9]/", '', $number)); // query only the numbers
});
```

**Address** are accessed via the addresses()” method (a MorphMany relationship):

```
<?php

// Add an address to a new model
$model = new Model;
$model->addresses()->save(new \Trexology\Contactable\Address(
    [
      'block' => '923',
      'unit' => '#08-110',
      'street' => 'Laravel Road 3',
      'postal_code' => '827923', // or zip or zip_code
      'country' => 'singapore',
      'country_code' => 'sg',
      'lat' => '-7.7871130',
      'long' => '39.7667430',
    ]
  ));

// Add multiple addresses to a pre-existing model
$model = Model::find(1);

$model->addresses()->saveMany([
    new \Trexology\Contactable\Address(
      [
        'block' => '923',
        'unit' => '#08-110',
        'street' => 'Laravel Road 3',
        'postal_code' => '827923', // or zip or zip_code
        'country' => 'singapore',
        'country_code' => 'sg',
        'lat' => '-7.7871130',
        'long' => '39.7667430',
      ]
    ),
    new \Trexology\Contactable\Address(
      [
        'block' => '782',
        'unit' => '#09-36',
        'street' => 'Laravel Road 3',
        'postal_code' => '876782', // or zip or zip_code
        'country' => 'singapore',
        'country_code' => 'sg',
        'lat' => '33.0691390',
        'long' => '44.0820410',
      ]
    ),
]);

// Query records which have at least two addresses
Model::has('addresses', '>=', 2)->get();

// Query records which have a specific street name
$street_name = '%Laravel Road 2%';
Model::whereHas('addresses', function ($query) use ($street_name) {
    $query->where('street', 'LIKE', $street_name);
});
```
