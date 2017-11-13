@extends('layouts.app', ['title' => 'Catégories', 'subtitle' => 'Modifier la catégorie: '. $category->name])

@section('content')
    <cat-create-view :data="{{ $categories }}" inline-template v-cloak>
        <div class="columns">
            <div class="column is-half-desktop">
                <form action="{{ route('categories.update', $category) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('patch') }}
                    <div class="card">
                        <header class="card-header">
                            <p class="card-header-title">
                                Modifier
                            </p>
                        </header>
                        <div class="card-content">
                            <div class="content">
                                <b-field label="Intitulé de la catégorie"
                                        {{ $errors->has('name') ? 'type="is-danger" message="' . $errors->first('name') . '"' : ''}}>
                                    <b-input maxlength="50" name="name" required autofocus
                                             value="{{ old('name', $category->name) }}"
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
