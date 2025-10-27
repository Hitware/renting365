<?php

namespace App\Traits;

use Vinkla\Hashids\Facades\Hashids;

trait HasHashedRouteKey
{
    public function getRouteKeyName()
    {
        return 'id';
    }

    public function getRouteKey()
    {
        return Hashids::encode($this->getKey());
    }

    public function resolveRouteBinding($value, $field = null)
    {
        $decoded = Hashids::decode($value);
        
        if (empty($decoded)) {
            return null;
        }

        return static::find($decoded[0]);
    }
}
