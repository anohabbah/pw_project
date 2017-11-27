<?php

namespace App\Http\Controllers;

use App\Media;
use App\Producteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        $this->validator($request->all())->validate();

        $producteur = $this->createProducer($request->all());

        // Active/Desactive le compte et active/desactive
        // la visibilité de l'adresse du producteut
        $this->updateProducerAccount($request, $producteur);

        $this->setAvatar($request, $producteur);

        return redirect()->route('producteurs.show', $producteur);
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
        $this->validator($request->all(), [
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('producteurs')->ignore($producteur->id_producteur, 'id_producteur')
            ],
            'telephone' => [
                'required',
                'string',
                'max:25',
                Rule::unique('producteurs')->ignore($producteur->id_producteur, 'id_producteur')
            ],
            'mot_de_passe' => 'sometimes|string|required|min:6|confirmed'
        ])->validate();

        $producteur->update($request->all());

        return redirect()->route('producteurs.show', $producteur);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Producteur  $producteur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producteur $producteur)
    {
        $producteur->delete();

        Session::flash('flash', 'Compte supprimé avec succès !');
        return redirect()->route('producteurs.index');
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
    protected function setAvatar(Request $request, Producteur $producteur)
    {
        if ($request->filled('avatar')) {
            // Effacer toutes images de profil déjà associées au compte d'un
            // producteur avant de lui associer une nouvelle image de profil
            $media = $producteur->media();
            if ($media->exists()) {
                $media->delete();
            }

            $media = Media::find($request->input('avatar'));
            $media->producteur()->associate($producteur);
            $media->save();
        }
    }

    public function validator(array $data, array $rules = [])
    {
        $defaultRules = [
            'nom' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:producteurs',
            'mot_de_passe' => 'required|string|min:6|confirmed',
            'adresse' => 'required|string|max:100',
            'telephone' => 'required|string|max:25|unique:producteurs',
            'bio' => 'required',
            'avatar' => 'nullable|exists:medias,id_media'
        ];

        $customMessages = [
            'avatar.exists' => 'La photo de profil doit être préalablement téléversée.'
        ];

        $rules = array_merge($defaultRules, $rules);
        return Validator::make($data, $rules, $customMessages);
    }
}
