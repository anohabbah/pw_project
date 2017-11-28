<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $primaryKey = 'id_media';

    protected $table = 'medias';

    public $timestamps = false;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Media $subject) {
            $subject->deleteFile();
        });
    }

    /**
     * Media may belong to a producteur.
     *
     */
    public function producteur()
    {
        return $this->belongsTo(Producteur::class, 'id_producteur', 'id_producteur');
    }

    /**
     * @param UploadedFile $file
     * @return $this
     */
    public function uploadFile(UploadedFile $file)
    {
        $path = $file->storePublicly('producteurs', ['disk' => 'public']);
        $this->url = asset('storage/' . $path);
        $this->save();

        return $this;
    }

    public function deleteFile()
    {
        $filename = basename($this->url);
        Storage::disk('public')->delete('producteurs/' . $filename);

        return $this;
    }
}
