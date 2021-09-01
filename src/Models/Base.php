<?php

namespace Yepwoo\Laragine\Models;

use Illuminate\Database\Eloquent\Model;
use Yepwoo\Laragine\Traits\Model\Uuid;

class Base extends Model
{
    use Uuid;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'uuid', 'created_at', 'updated_at'];
}
