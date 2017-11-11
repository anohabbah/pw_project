<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Categorizable;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($item) {
            $item->subCategories->each->delete();
            $item->products->each->delete();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subCategories()
    {
        return $this->hasMany(Category::class, 'category_id');
    }

    /**
     * @param $attributes
     * @return Model
     */
    public function addChildCategory($attributes)
    {
        return $this->subCategories()->create($attributes);
    }
}
