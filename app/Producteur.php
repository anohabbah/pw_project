<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producteur extends Model
{
    /**
     * @inherited
     */
    protected $primaryKey = 'id_producteur';

    public $timestamps = false;
}
