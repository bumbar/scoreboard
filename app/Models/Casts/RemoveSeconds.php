<?php


namespace App\Models\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class RemoveSeconds implements CastsAttributes
{

    /**
     * @inheritDoc
     */
    public function get($model, string $key, $value, array $attributes)
    {
        // TODO: Implement get() method.
    }

    /**
     * @inheritDoc
     */
    public function set($model, string $key, $value, array $attributes)
    {
        // TODO: Implement set() method.
    }
}
