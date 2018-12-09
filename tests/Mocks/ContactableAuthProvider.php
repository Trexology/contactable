<?php

namespace Trexology\Contactable\Tests\Mocks;

use Trexology\Contactable\Providers\ContactableAuthProvider as BaseContactableAuthProvider;

class ContactableAuthProvider extends BaseContactableAuthProvider {

    protected $model = \Trexology\Contactable\Tests\Mocks\User::class;

}
