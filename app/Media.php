<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $primaryKey = 'id_media';

    protected $table = 'medias';

    public $timestamps = false;

    /**
     * Media may belong to a producteur.
     *
     */
    public function producteur()
    {
        return $this->belongsTo(Producteur::class, 'id_producteur', 'id_producteur');
    }
}
