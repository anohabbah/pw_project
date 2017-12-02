<?php

namespace App\Http\Controllers;

use App\Media;
use App\Producteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        return view('producteurs.index');
    }

    /**
     * Fetch all producer account.
     *
     * @return mixed
     */
    public function fetch()
    {
        return Producteur::orderBy('nom')->get();
    }

    /**
     * Update account status.
     *
     * @param Request $request
     * @param Producteur $producteur
     * @return Producteur
     */
    public function status(Request $request, Producteur $producteur)
    {
        $producteur->update(['actif' => $request->input('actif')]);

        return $producteur->fresh();
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
        return view('producteurs.edit')->with('producteur', $producteur);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Producteur  $producteur
     * @return \Illuminate\Http\Response|JsonResponse
     */
    public function update(Request $request, Producteur $producteur)
    {
        $data = $request->all();
        $this->validator($data, [
            'email' => [
                'sometimes',
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
            'mot_de_passe' => 'sometimes|required|string|min:6|confirmed'
        ])->validate();

        $this->updateProducer($data, $producteur);

        if ($request->has('mot_de_passe')) {
            $producteur->update(['mot_de_passe' => bcrypt($request->input('mot_de_passe'))]);
        }

        $this->updateProducerAccount($request, $producteur);

        if ($request->wantsJson()) {
            return new JsonResponse($producteur->fresh());
        }

        return redirect()->route('producteurs.show', $producteur);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Producteur  $producteur
     * @return \Illuminate\Http\Response|JsonResponse
     */
    public function destroy(Producteur $producteur)
    {
        $producteur->delete();

        if (\request()->wantsJson()) {
            return new JsonResponse($producteur);
        }

        Session::flash('flash', 'Compte supprimé avec succès !');
        return redirect()->route('producteurs.index');
    }

    /**
     * @param Request $request
     * @param $producteur
     */
    protected function updateProducerAccount(Request $request, Producteur $producteur)
    {
        $producteur->updateStates($request->filled('adresse_visible'), $request->filled('actif'));
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

    /**
     * @param array $data
     * @param Producteur $producteur
     * @return bool
     */
    protected function updateProducer(array $data, Producteur $producteur)
    {
        return $producteur->update([
            'nom' => $data['nom'],
//            'email' => $data['email'],
            'telephone' => $data['telephone'],
            'adresse' => $data['adresse'],
            'bio' => $data['bio'],
            'longitude' => $data['longitude'],
            'latitude' => $data['latitude']
        ]);
    }
}
