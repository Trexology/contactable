<?php

namespace Trexology\Contactable;

use Trexology\Contactable\Traits\IncrementsPosition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model {

    use SoftDeletes, IncrementsPosition;

    protected $table = 'addresses';
    protected $autoPositionBasedOnFields = ['addressable_id', 'addressable_type'];

    protected $fillable = ['block', 'unit', 'street', 'street_extra', 'city', 'subdivision', 'state', 'province', 'postal_code', 'zip', 'zip_code', 'country', 'country_code', 'lat', 'long'];
    protected $visible = ['block', 'unit', 'street', 'street', 'street_extra', 'city', 'subdivision', 'postal_code', 'country', 'country_code', 'lat', 'long'];
    protected $touches = ['addressable'];

    /**
     * Relationship to other models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function addressable()
    {
        return $this->morphTo();
    }

    public function setStateAttribute($value)
    {
        $this->setAttribute('subdivision', $value);
    }

    public function setProvinceAttribute($value)
    {
        $this->setAttribute('subdivision', $value);
    }

    public function setZipAttribute($value)
    {
        $this->setAttribute('postal_code', $value);
    }

    public function setZipCodeAttribute($value)
    {
        $this->setAttribute('postal_code', $value);
    }

    public function render()
    {
        return view('contactable::address.' . $this->country, $this->toArray())
            ->render();
    }

    public function getRenderedAttribute()
    {
        return $this->render();
    }

    public function __toString()
    {
        return $this->render();
    }
}
