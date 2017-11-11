<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producer extends Model
{
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function media()
    {
        return $this->morphOne(Media::class, 'subject');
    }
}
