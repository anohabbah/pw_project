<?php

namespace App\Http\Controllers;

use App\Media;
use App\Producteur;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MediaController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, ['avatar' => 'required|file|image']);
    }

    /**
     * @param Request $request
     * @return Media
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $media = new Media();
        $media->uploadFile($this->getFile($request));

        return $media;
    }

    public function update(Request $request, Producteur $producteur)
    {
        $this->validator($request->all())->validate();

        // Le producteur n'a qu'une seule image de profile
        $oldMedia = $producteur->media();
        if ($oldMedia->exists()) {
            $oldMedia->delete();
        }

        $media = new Media(['id_producteur' => $producteur->id_producteur]);
        $media->uploadFile($this->getFile($request));

        return new JsonResponse($media);
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\UploadedFile|null
     */
    protected function getFile(Request $request)
    {
        $avatar = $request->file('avatar');
        return $avatar;
    }
}
