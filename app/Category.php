<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Categorizable;

    protected $guarded = [];

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function list()
    {
        return static::with('children')
            ->whereNull('category_id')
            ->orderBy('name')
            ->simplePaginate(2);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($item) {
            $item->children->each->delete();
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
    public function children()
    {
        return $this->hasMany(Category::class, 'category_id');
    }

    /**
     * @param $attributes
     * @return Model
     */
    public function addChildCategory($attributes)
    {
        return $this->children()->create($attributes);
    }
}
