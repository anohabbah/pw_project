<?php

namespace App\Http\Controllers;

use App\Producteur;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * @param Request $request
     * @param Producteur $producteur
     * @return Producteur
     */
    public function update(Request $request, Producteur $producteur)
    {
        $producteur->update(['adresse_visible' => $request->input('adresse_visible')]);

        return $producteur->fresh();
    }
}
