@extends('layouts.app', ['title' => 'Catégories', 'subtitle' => 'Modifier la catégorie: '. $category->nom_categorie])

@section('content')
    <cat-create-view
            :current="{{ old('f_id_categorie', $category->f_id_categorie ?: '[]') }}"
                     :data="{{ $categories }}" inline-template v-cloak>
        <div class="columns">
            <div class="column is-half-desktop">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            Modifier
                        </p>
                    </header>
                    <div class="card-content">
                        <div class="content">
                            <form id="categ_form" action="{{ route('categories.update', $category) }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}

                                <b-field label="Intitulé de la catégorie"
                                        {{ $errors->has('nom_categorie') ? 'type="is-danger" message="' . $errors->first('nom_categorie') . '"' : ''}}>
                                    <b-input maxlength="100" name="nom_categorie" required autofocus
                                             value="{{ old('nom_categorie', $category->nom_categorie) }}"
                                             placeholder="Indiquer ici l'intitulé de la nouvelle catégorie"></b-input>
                                </b-field>

                                <b-field
                                        {{ $errors->has('f_id_category') ? 'type="is-danger" message="' . $errors->first('f_id_category') . '"' : ''}}
                                        label="Catégories"
                                        message="Ne selectionner que si vous voulez defenir la nouvelle catégorie comme une sous catégorie d'une autre">
                                    <b-select placeholder="Sélectionner une catégorie (optionnel)"
                                              v-model="categorySelected" name="f_id_category">
                                        <option
                                                v-for="category in categories"
                                                :value="category.id_categorie"
                                                :key="category.id_categorie"
                                                v-text="category.nom_categorie"
                                        ></option>
                                    </b-select>
                                </b-field>
                            </form>
                        </div>
                    </div>
                    <footer class="card-footer">
                        <a class="card-footer-item" href="{{ route('categories.index') }}" class="button is-white">Annuler</a>
                        <a class="card-footer-item" href="#"
                           onclick="event.preventDefault();document.getElementById('categ_form').submit();">Enregistrer les modifications</a>
                    </footer>
                </div>
            </div>
        </div>
    </cat-create-view>
@endsection
