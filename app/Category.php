<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Categorizable;

    protected $primaryKey = 'id_categorie';

    protected $guarded = [];

    public $timestamps = false;

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function list()
    {
        return static::with('children')
            ->whereNull('f_id_categorie')
            ->orderBy('nom_categorie')
            ->simplePaginate(2);
    }

    public static function parents()
    {
        return static::whereNull('f_id_categorie')->orderBy('nom_categorie')->get();
    }

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($item) {
            $item->children->each->delete();
            $item->produits->each->delete();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function produits()
    {
        return $this->hasMany(Produit::class, 'id_categorie', 'id_categorie');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'f_id_categorie', 'id_categorie');
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
