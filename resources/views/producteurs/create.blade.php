@extends('layouts.app', ['title' => 'Producteurs', 'subtitle' => 'Ajouter un producteur'])

@section('content')
    <prod-create-view
            inline-template v-cloak
            {!! old('avatar') ? ':profile-avatar="' . old('avatar') . '"' : '' !!}
            {!! old('longitude') ? ':lng="' . old('longitude') . '"' : ''  !!}
            {!! old('latitude') ? ':lati="' . old('latitude') . '"' : '' !!}
            {{ old('adresse_visible') ?
                ':adresse-visible="' . old('adresse_visible') . '"' : '' }}
            {{ old('actif') ? ':actif="' . old('actif') . '"' : '' }}>
        <div class="colums producers-page">
            <div class="column">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-title">
                            Producteurs
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="content">
                            <form action="{{ route('producteurs.store') }}" method="post" id="prod_form"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <input type="hidden" name="avatar" :value="id_media">
                                <input type="hidden" name="longitude" :value="long">
                                <input type="hidden" name="latitude" :value="lat">

                                <div class="columns">
                                    <div class="column is-half-desktop">
                                        <b-field
                                                {!! old('avatar') ?
                                                    'type="is-success" message="Une image de profil est déjà associé à ce compte"' : '' !!}
                                                {!! $errors->has('avatar') ?
                                                'type="is-danger" message="' . $errors->first('avatar') . '"' : '' !!}>
                                            <b-tooltip label="Ajouter un photo" position="is-right">
                                                <a class="button is-primary is-large is-circle" @click="toggleShow">
                                                    <b-icon icon="add_a_photo" type="is-medium"></b-icon>
                                                </a>
                                            </b-tooltip>
                                            <image-upload
                                                    field="avatar"
                                                    @crop-success="cropSuccess"
                                                    @crop-upload-success="cropUploadSuccess"
                                                    @crop-upload-fail="cropUploadFail"
                                                    v-model="show"
                                                    :width="300"
                                                    :height="300"
                                                    url="{{ route('media.store') }}"
                                                    :headers="headers"
                                                    lang-type="fr"
                                                    img-format="png"></image-upload>
                                            <a @click="toggleShow">
                                                <img class="profile-pic img-circle" :src="imgDataUrl" v-if="imgDataUrl">
                                            </a>
                                        </b-field>

                                        <b-field label="Nom du producteur"
                                                {!! $errors->has('nom') ?
                                                'type="is-danger" message="' . $errors->first('nom') . '"' : '' !!}>
                                            <b-input name="nom" required
                                                     maxLength="100"
                                                     value="{{ old('nom') }}"></b-input>
                                        </b-field>

                                        <b-field label="Adresse électronique"
                                                {!! $errors->has('email') ?
                                                'type="is-danger" message="' . $errors->first('email') . '"' : '' !!}>
                                            <b-input name="email" required maxLength="100"
                                                     value="{{ old('email') }}"></b-input>
                                        </b-field>
                                        <b-field
                                                label="Mot de passe"
                                                {!! $errors->has('mot_de_passe') ?
                                                'type="is-danger" message="' . $errors->first('mot_de_passe') . '"' : '' !!}>
                                            <b-input type="password" required minLength="6" :has-counter="false"
                                                     password-reveal name="mot_de_passe"></b-input>
                                        </b-field>
                                        <b-field label="Confirmer le mot de passe">
                                            <b-input type="password" required password-reveal
                                                     name="mot_de_passe_confirmation"></b-input>
                                        </b-field>

                                        <b-field label="Adresse postale du producteur"
                                                {!! $errors->has('adresse') ?
                                          'type="is-danger" message="' . $errors->first('adresse') . '"' : '' !!}>
                                            <div class="control is-clearfix">
                                                <gmap-autocomplete
                                                        class="input"
                                                        name="adresse"
                                                        value="{{ old('adresse') }}"
                                                        @place_changed="setPlace"></gmap-autocomplete>
                                            </div>
                                        </b-field>
                                        <b-field>
                                            <b-tooltip
                                                    label="Activer ou desactiver la visibilité de l'adresse du producteur sur le site">
                                                <b-switch
                                                        v-model="addressState"
                                                        name="adresse_visible"
                                                        true-value="Visible"
                                                        false-value="Non Visible">
                                                    @{{ addressState }}
                                                </b-switch>
                                            </b-tooltip>
                                        </b-field>

                                        <b-field label="Numéro de téléphone"
                                                {!! $errors->has('telephone') ?
                                                'type="is-danger" message="' . $errors->first('telephone') . '"' : '' !!}>
                                            <b-input name="telephone" required
                                                     value="{{ old('telephone') }}"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column is-half-desktop">
                                        <b-field
                                                label="Biographie du producteur"
                                                {!! $errors->has('bio') ?
                                                'type="is-danger" message="' . $errors->first('bio') . '"' : '' !!}>
                                            <b-input
                                                    type="textarea"
                                                    placeholder="Décrire en quelques mots le producteur."
                                                    value="{{ old('bio') }}"
                                                    name="bio"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="producer-footer">
                                    <div class="columns">
                                        <div class="column">
                                            <div class="field">
                                                <b-switch :value="true"
                                                          size="is-medium"
                                                          v-model="accountState"
                                                          name="actif"
                                                          true-value="Compte Activé"
                                                          false-value="Compte Non Activé"
                                                          type="is-info">@{{ accountState }}
                                                </b-switch>
                                            </div>
                                        </div>
                                        <div class="column">
                                            <button type="submit"
                                                    class="button is-primary is-pulled-right">Créer le compte
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </prod-create-view>
@endsection

@push('styles')
    <script>
        window.App = {!! json_encode([
            'baseDir' => public_path()
        ]) !!}
    </script>
@endpush

@push('scripts')
    <script src="{{ asset('js/tinymce/tiny_mce.js') }}"></script>
    <script src="{{ asset('js/tinymce.inc.js') }}"></script>
    <script src="{{ asset('js/tinymce_loader.js') }}"></script>
@endpush
