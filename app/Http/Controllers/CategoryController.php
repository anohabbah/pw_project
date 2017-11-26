<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
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
        $categories = Category::list();

        return view('categories.index')->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create')->with('categories', $this->getCategories());
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
            'f_id_categorie' => 'nullable|exists:categories,id_categorie',
            'nom_categorie' => 'required|string',
        ]);

        if ($request->has('f_id_categorie')) {
            /** @var Category $parent */
            $parent = Category::findOrfail($request->input('f_id_categorie'));
            $parent->addChildCategory([
                'nom_categorie' => ucwords($request->input('nom_categorie'))
            ]);
        } else {
            $cat = new Category();
            $cat->nom_categorie = ucwords($request->input('nom_categorie'));
            $cat->save();
        }

        Session::flash('flash', 'Catégorie ajoutée avec succès !');
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('categories.edit')
            ->with('category', $category)
            ->with('categories', $this->getCategories());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'f_id_categorie' => 'nullable|exists:categories,id_categorie',
            'nom_categorie' => 'required'
        ]);

        $category->update($data);

        Session::flash('flash', 'Mise à jour réussie !');
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        Session::flash('flash', 'Suppression réussie !');
        return redirect()->route('categories.index');
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return Category::parents();
    }
}
