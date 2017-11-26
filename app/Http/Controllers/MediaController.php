<?php

namespace App\Http\Controllers;

use App\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['avatar' => 'required|file|image']);

        $avatar = $request->file('avatar');
        $media = new Media();
        $media->uploadFile($avatar);

        return $media;
    }
}
