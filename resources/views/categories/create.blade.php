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
                                        {{ $errors->has('name') ? 'type="is-danger" message="' . $errors->first('name') . '"' : ''}}>
                                    <b-input maxlength="50" name="name" required
                                             value="{{ old('name') }}"
                                             placeholder="Indiquer ici l'intitulé de la nouvelle catégorie"></b-input>
                                </b-field>

                                <b-field
                                        {{ $errors->has('category_id') ? 'type="is-danger" message="' . $errors->first('category_id') . '"' : ''}}
                                        label="Catégories"
                                        message="Ne selectionner que si vous voulez defenir la nouvelle catégorie comme une sous catégorie d'une autre">
                                    <b-select placeholder="Sélectionner une catégorie (optionnel)" name="category_id">
                                        <option
                                                v-for="category in categories"
                                                :value="category.id"
                                                :key="category.id"
                                                v-text="category.name"
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
