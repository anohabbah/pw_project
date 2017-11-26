<?php

namespace App\Http\Controllers;

use App\Media;
use App\Producteur;
use Illuminate\Http\Request;

class ProducteurController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('producteurs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:producteurs',
            'mot_de_passe' => 'required|string|min:6|confirmed',
            'adresse' => 'required|string|max:100',
            'telephone' => 'required|string|max:25|unique:producteurs',
            'bio' => 'required',
            'avatar' => 'nullable|exists:medias,id_media'
        ], [
            'avatar.exists' => 'La photo de profil doit être préalablement téléversée.'
        ]);

        $producteur = $this->createProducer($request->all());

        // Active/Desactive le compte et active/desactive
        // la visibilité de l'adresse du producteut
        $this->updateProducerAccount($request, $producteur);

        $this->setAvatar($request, $producteur);

        return redirect()->route('producers.show', $producteur);
    }

    protected function createProducer(array $data)
    {
        return Producteur::create([
            'nom' => ucwords($data['nom']),
            'email' => $data['email'],
            'mot_de_passe' => bcrypt($data['mot_de_passe']),
            'adresse' => $data['adresse'],
            'telephone' => $data['telephone'],
            'bio' => $data['bio'],
            'longitude' => $data['longitude'],
            'latitude' => $data['latitude'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Producteur  $producteur
     * @return \Illuminate\Http\Response
     */
    public function show(Producteur $producteur)
    {
        return view('producteurs.show')->with('producteur', $producteur);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Producteur  $producteur
     * @return \Illuminate\Http\Response
     */
    public function edit(Producteur $producteur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Producteur  $producteur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producteur $producteur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Producteur  $producteur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producteur $producteur)
    {
        //
    }

    /**
     * @param Request $request
     * @param $producteur
     */
    protected function updateProducerAccount(Request $request, $producteur)
    {
        $producteur->updateStates($request->filled('actif'), $request->filled('adresse_visible'));
    }

    /**
     * @param Request $request
     * @param $producteur
     */
    protected function setAvatar(Request $request, $producteur)
    {
        if ($request->filled('avatar')) {
            $media = Media::find($request->input('avatar'));
            $media->producteur()->associate($producteur);
            $media->save();
        }
    }
}
