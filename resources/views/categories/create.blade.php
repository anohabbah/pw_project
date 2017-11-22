@extends('layouts.app', ['title' => 'Catégories', 'subtitle' => 'Ajouter une nouvelle catégorie'])

@section('content')
    <cat-create-view inline-template v-cloak>
        <div class="columns">
            <div class="column is-half-desktop">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            Ajouter une nouvelle catégorie
                        </p>
                    </header>
                    <div class="card-content">
                        <div class="content">
                            <form id="categ_form" action="{{ route('categories.store') }}" method="post">
                                {{ csrf_field() }}
                                <b-field label="Intitulé de la catégorie"
                                        {{ $errors->has('nom_categorie') ? 'type="is-danger" message="' . $errors->first('nom_categorie') . '"' : ''}}>
                                    <b-input maxlength="100" name="nom_categorie" required
                                             value="{{ old('nom_categorie') }}"
                                             placeholder="Indiquer ici l'intitulé de la nouvelle catégorie"></b-input>
                                </b-field>

                                <b-field
                                        {{ $errors->has('f_id_categorie') ? 'type="is-danger" message="' . $errors->first('f_id_categorie') . '"' : ''}}
                                        label="Catégories"
                                        message="Ne selectionner que si vous voulez defenir la nouvelle catégorie comme une sous catégorie d'une autre">
                                    <b-select placeholder="Sélectionner une catégorie (optionnel)" name="f_id_categorie">
                                        <option
                                                v-for="category in categories"
                                                :value="category.id"
                                                :key="category.id_categorie"
                                                v-text="category.nom_categorie"
                                        ></option>
                                    </b-select>
                                </b-field>
                            </form>
                        </div>
                    </div>
                    <footer class="card-footer">
                        <a class="card-footer-item" href="{{ route('categories.index') }}">Annuler</a>
                        <a class="card-footer-item" href="#"
                           onclick="event.preventDefault();document.getElementById('categ_form').submit();">Ajouter</a>
                    </footer>
                </div>
            </div>
        </div>
    </cat-create-view>
@endsection
