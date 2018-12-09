<?php

namespace Trexology\Contactable\Tests\Mocks;

use App\User as BaseUser;
use Trexology\Contactable\Traits\Contactable;
use Trexology\Contactable\Traits\Nameable;

class User extends BaseUser {
    use Contactable;

    protected $morphClass = 'Trexology\Contactable\Tests\Mocks\User';
}
