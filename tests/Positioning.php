<?php

namespace Trexology\Contactable\Tests;

use Trexology\Contactable\Address;
use Trexology\Contactable\EmailAddress;
use Trexology\Contactable\PhoneNumber;
use Trexology\Contactable\Tests\Cases\UserTestCase;

class Positioning extends UserTestCase {
    public function test_items_are_positioned_on_creation()
    {
        $user = $this->createUser(['name' => 'The Simpsons']);

        $user->emails()->save(new EmailAddress(['address' => 'homer@example.com']));
        $user->emails()->save(new EmailAddress(['address' => 'marge@example.com']));
        $user->emails()->save(new EmailAddress(['address' => 'bart@example.com']));
        $user->emails()->save(new EmailAddress(['address' => 'lisa@example.com']));
        $user->emails()->save(new EmailAddress(['address' => 'maggie@example.com']));

        $user->phones()->save(new PhoneNumber(['number' => '123 456 7890']));
        $user->phones()->save(new PhoneNumber(['number' => '234 567 8901']));
        $user->phones()->save(new PhoneNumber(['number' => '345 678 9012']));

        $user->addresses()->save(new Address(['city' => 'Chattanooga']));
        $user->addresses()->save(new Address(['city' => 'New York']));
        $user->addresses()->save(new Address(['city' => 'Austin']));
        $user->addresses()->save(new Address(['city' => 'San Francisco']));

        $this->assertEquals([0,1,2,3,4], $user->emails()->lists('position')->toArray());
        $this->assertEquals([0,1,2], $user->phones()->lists('position')->toArray());
        $this->assertEquals([0,1,2,3], $user->addresses()->lists('position')->toArray());
    }

    public function test_can_access_primary_items()
    {
        $user = $this->createUser(['name' => 'The Simpsons']);

        $user->emails()->save(new EmailAddress(['address' => 'homer@example.com']));
        $user->emails()->save(new EmailAddress(['address' => 'marge@example.com']));

        $user->phones()->save(new PhoneNumber(['number' => '234 567 8901']));

        $user->addresses()->save(new Address(['city' => 'Springfield']));
        $user->addresses()->save(new Address(['city' => 'Ogdenville']));
        $user->addresses()->save(new Address(['city' => 'Brockway']));
        $user->addresses()->save(new Address(['city' => 'North Haverbrook']));

        $this->assertEquals('homer@example.com', $user->primaryEmail()->address);
        $this->assertEquals('234 567 8901', $user->primaryPhone()->number);
        $this->assertEquals('Springfield', $user->primaryAddress()->city);
    }
}
