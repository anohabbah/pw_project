<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $primaryKey = 'id_media';

    protected $table = 'medias';

    public $timestamps = false;
}
