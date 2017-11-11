<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Categorizable;

    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function media()
    {
        return $this->morphMany(Media::class, 'subject');
    }
}
