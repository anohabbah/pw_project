<?php

namespace App\Http\Controllers;

use App\Producteur;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * @param Request $request
     * @param Producteur $producteur
     * @return Producteur
     */
    public function update(Request $request, Producteur $producteur)
    {
        $producteur->update(['actif' => $request->input('actif')]);

        return $producteur->fresh();
    }
}
