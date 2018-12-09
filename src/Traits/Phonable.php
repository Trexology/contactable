<?php

/**
 * Relates any model with phone numbers.
 */

namespace Trexology\Contactable\Traits;

use Trexology\Contactable\PhoneNumber;

trait Phonable
{
    /**
     * The relationship to other models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function phones()
    {
        return $this->morphMany(config('contactable.models.phone', PhoneNumber::class), 'phonable')
            ->orderBy('position', 'asc');
    }

    public function primaryPhone()
    {
        return $this->phones ? $this->phones->first() : null;
    }
}
