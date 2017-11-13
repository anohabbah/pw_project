@extends('layouts.app', ['title' => 'Catégories', 'subtitle' => 'Ajouter une nouvelle catégorie'])

@section('content')
    <cat-create-view :data="{{ $categories }}" inline-template v-cloak>
        <div class="columns">
            <div class="column is-half-desktop">
                <form action="{{ route('categories.store') }}" method="post">
                    {{ csrf_field() }}
                    <div class="card">
                        <header class="card-header">
                            <p class="card-header-title">
                                Ajouter une nouvelle catégorie
                            </p>
                        </header>
                        <div class="card-content">
                            <div class="content">
                                <b-field label="Intitulé de la catégorie">
                                    <b-input maxlength="50" name="name" required autofocus
                                             placeholder="Indiquer ici l'intitulé de la nouvelle catégorie"></b-input>
                                </b-field>

                                <b-field
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
                            </div>
                        </div>
                        <footer class="card-footer">
                            <p class="card-footer-item">
                                <a href="{{ route('categories.index') }}" class="button is-white">Annuler</a>
                            </p>
                            <p class="card-footer-item">
                                <button class="button is-primary" type="submit">Ajouter</button>
                            </p>
                        </footer>
                    </div>
                </form>
            </div>
        </div>
    </cat-create-view>
@endsection
