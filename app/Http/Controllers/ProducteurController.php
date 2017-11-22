<?php

namespace App\Http\Controllers;

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
        $data = $request->validate([
            'nom' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:producteurs',
            'mot_de_passe' => 'required|string|min:6|confirmed',
            'adresse' => 'required|string|max:100',
            'telephone' => 'required|string|max:25',
            'bio' => 'required',
        ]);

        /** @var Producteur $producteur */
        $producteur = Producteur::create($data);

        // Active/Desactive le compte et active/desactive la visibilité de l'adresse du producteut
        $producteur->updateStates($request->filled('actif'), $request->filled('adresse_visible'));

        return redirect()->route('producers.show', $producteur);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Producteur  $producteur
     * @return \Illuminate\Http\Response
     */
    public function show(Producteur $producteur)
    {
        //
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
}
