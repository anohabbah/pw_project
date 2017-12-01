@extends('layouts.app', ['title' => 'Producteurs', 'subtitle' => 'Modification de profil'])

@section('content')
    <prod-edit-view
            inline-template v-cloak
            {{ $producteur->media
                ? ':avatar="' . $producteur->media->url .'"'
                : ':avatar="https://www.gravatar.com/avatar/' . md5($producteur->email) . '?s=100"' }}
            {!! old('longitude', $producteur->longitude) ? ':lng="' . old('longitude', $producteur->longitude) . '"' : ''  !!}
            {!! old('latitude', $producteur->latitude) ? ':lat="' . old('latitude', $producteur->latitude) . '"' : '' !!}
            {{ old('adresse_visible', $producteur->adresse_visible) ?
                ':adresse-visible="' . old('adresse_visible', $producteur->adresse_visible) . '"' : '' }}
            {{ old('actif', $producteur->actif) ? ':actif="' . old('actif', $producteur->actif) . '"' : '' }}>
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
                            <form action="{{ route('producteurs.update', $producteur) }}" method="post" id="prod_form"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('put') }}

                                <input type="hidden" name="longitude" :value="position.lng">
                                <input type="hidden" name="latitude" :value="position.lat">

                                <div class="columns">
                                    <div class="column is-half-desktop">
                                        <b-field>
                                            <div class="avatar-container" style="margin: 0 !important;">
                                                <img :src="imgDataUrl" alt="{{ $producteur->nom }}"
                                                     class="profile-pic is-centered img-circle">

                                                <div class="add-profile-pic">
                                                    <b-tooltip label="Modifier la photo de profil" position="is-right">
                                                        <a class="button is-primary is-circle" @click="toggleShow">
                                                            <b-icon icon="add_a_photo"></b-icon>
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
                                                            url="{{ route('media.update', $producteur) }}"
                                                            :headers="headers"
                                                            lang-type="fr"
                                                            img-format="png"></image-upload>
                                                </div>
                                            </div>
                                        </b-field>

                                        <b-field label="Nom du producteur"
                                                {!! $errors->has('nom') ?
                                                'type="is-danger" message="' . $errors->first('nom') . '"' : '' !!}>
                                            <b-input name="nom" required
                                                     maxLength="100"
                                                     value="{{ old('nom', $producteur->nom) }}"></b-input>
                                        </b-field>

                                        <b-field label="Adresse électronique"
                                                {!! $errors->has('email') ?
                                                'type="is-danger" message="' . $errors->first('email') . '"' : '' !!}>
                                            <b-input name="email" required maxLength="100"
                                                     value="{{ old('email', $producteur->email) }}" disabled></b-input>
                                        </b-field>

                                        <b-field label="Mot de passe">
                                            <a @click="togglePassword"
                                                    class="button" v-text="passwordButtonText"></a>
                                        </b-field>

                                        <div v-if="modifyPassword">
                                            <b-field
                                                    {!! $errors->has('mot_de_passe') ?
                                                    'type="is-danger" message="' . $errors->first('mot_de_passe') . '"' : '' !!}>
                                                <b-input type="password" required minLength="6" :has-counter="false"
                                                         password-reveal name="mot_de_passe"></b-input>
                                            </b-field>
                                            <b-field label="Confirmer le mot de passe">
                                                <b-input type="password" required password-reveal
                                                         name="mot_de_passe_confirmation"></b-input>
                                            </b-field>
                                        </div>

                                        <b-field label="Adresse postale du producteur"
                                                {!! $errors->has('adresse') ?
                                          'type="is-danger" message="' . $errors->first('adresse') . '"' : '' !!}>
                                            <div class="control is-clearfix">
                                                <gmap-autocomplete
                                                        class="input"
                                                        name="adresse"
                                                        value="{{ old('adresse', $producteur->adresse) }}"
                                                        @place_changed="setPlace"></gmap-autocomplete>
                                            </div>
                                        </b-field>
                                        <b-field>
                                            <b-tooltip
                                                    label="Active/Désactive la visibilité de l'adresse sur le site"
                                                    position="is-right" multilined>
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
                                                     value="{{ old('telephone', $producteur->telephone) }}"></b-input>
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
                                                    value="{{ old('bio', $producteur->bio) }}"
                                                    name="bio"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="producer-footer">
                                    <div class="columns">
                                        <div class="column">
                                            <div class="field">
                                                <b-tooltip
                                                        label="Si désactivé, le detenteur de ce compte ne plus se connecter au site. Ce compte ne pourra plus être utilisé pour publier des avis."
                                                        position="is-right" multilined>
                                                    <b-switch :value="true"
                                                              size="is-medium"
                                                              v-model="accountState"
                                                              name="actif"
                                                              true-value="Activé"
                                                              false-value="Non Activé"
                                                              type="is-info">@{{ accountState }}
                                                    </b-switch>
                                                </b-tooltip>
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
    </prod-edit-view>
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
