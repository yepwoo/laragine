<?php

namespace Core\Base\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Base extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'uuid', 'created_at', 'updated_at'];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        $namespace        = explode('\\', static::class);
        $module_namespace = "{$namespace[0]}\\{$namespace[1]}";
        $factory          = "{$module_namespace}\\Database\\Factories\\{$namespace[sizeof($namespace) - 1]}Factory";

        return $factory::new();
    }
}
