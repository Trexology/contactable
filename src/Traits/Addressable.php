<?php

/**
 * Relates any model with real-world addresses.
 */

namespace Trexology\Contactable\Traits;

use Trexology\Contactable\Address;

trait Addressable
{
    /**
     * The relationship to other models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function addresses()
    {
        return $this->morphMany(config('contactable.models.address', Address::class), 'addressable')
            ->orderBy('position', 'asc');
    }

    public function primaryAddress()
    {
        return $this->addresses ? $this->addresses->first() : null;
    }
}
