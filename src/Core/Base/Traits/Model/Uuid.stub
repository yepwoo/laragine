<?php

namespace Core\Base\Traits\Model;

use Illuminate\Support\Str;

trait Uuid
{
    /**
     * Generate UUID v4 when creating model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        self::uuid();
    }

    /**
     * Use if boot() is overridden in the model.
     *
     * @return void
     */
    protected static function uuid()
    {
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
