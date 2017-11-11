<?php
/**
 * Created by IntelliJ IDEA.
 * User: Mecodeboue
 * Date: 11/11/2017
 * Time: 18:33
 */

namespace App;


trait Categorizable
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}