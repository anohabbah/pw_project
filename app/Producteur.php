<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producteur extends Model
{
    protected $fillable = [
        'nom', 'adresse', 'adresse_visible', 'email', 'mot_de_passe',
        'telephone', 'longitude', 'latitude', 'bio', 'actif'
    ];

    /**
     * @inherited
     */
    protected $primaryKey = 'id_producteur';

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Producteur $subject) {
            $media = $subject->media();
            if ($media->exists()) {
                $media->delete();
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function media()
    {
        return $this->hasOne(Media::class, 'id_producteur', 'id_producteur');
    }

    /**
     * @param bool $adresse_visible
     * @param bool $actif
     * @return bool
     */
    public function updateStates($adresse_visible = false, $actif = false)
    {
        return $this->update([
            'adresse_visible' => $adresse_visible,
            'actif' => $actif
        ]);
    }
}
