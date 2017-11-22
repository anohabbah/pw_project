@extends('layouts.app', ['title' => 'Producteurs', 'subtitle' => 'Ajouter un producteur'])

@section('content')
    <prod-create-view inline-template v-cloak>
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
                            <form action="{{ route('producers.store') }}" method="post" id="prod_form" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="columns">
                                    <div class="column is-half-desktop">
                                        <b-field label="Nom du producteur"
                                                {{ $errors->has('nom') ? 'type="is-danger" message="' . $errors->first('nom') . '"' : ''}}>
                                            <b-input name="nom" required
                                                     maxLength="100"
                                                     value="{{ old('nom') }}"></b-input>
                                        </b-field>

                                        <b-field label="Photo de Profil du producteur">
                                            <b-upload v-model="dropFiles"
                                                      name="avatar" drag-drop>
                                                <section class="section">
                                                    <div class="content has-text-centered">
                                                        <p><b-icon icon="add_a_photo" size="is-large"></b-icon></p>
                                                        <p>Glisser & Deposer ou Clicker pour télécharger une image</p>
                                                    </div>
                                                </section>
                                            </b-upload>
                                        </b-field>

                                        <div class="tags">
                                            <span v-for="(file, index) in dropFiles"
                                                  :key="index"
                                                  class="tag is-primary">
                                                @{{ file.name }}
                                                <button class="delete is-small"
                                                        type="button"
                                                        @click="deleteDropFile(index)">
                                                </button>
                                            </span>
                                        </div>

                                        <b-field label="Adresse électronique"
                                                {{ $errors->has('email') ? 'type="is-danger" message="' . $errors->first('email') . '"' : ''}}>
                                            <b-input name="email" required maxLength="100"
                                                     value="{{ old('email') }}"></b-input>
                                        </b-field>
                                        <b-field
                                                label="Mot de passe"
                                                {{ $errors->has('password') ?
                                                'type="is-danger" message="' . $errors->first('password') . '"' : ''}}>
                                            <b-input type="password" required minLength="6" :has-counter="false"
                                                     password-reveal name="mot_de_passe"></b-input>
                                        </b-field>
                                        <b-field label="Confirmer le mot de passe">
                                            <b-input type="password" required password-reveal
                                                     name="mot_de_passe_confirmation"></b-input>
                                        </b-field>

                                        <b-field label="Adresse postale du producteur"
                                                {{ $errors->has('adresse') ?
                                          'type="is-danger" message="' . $errors->first('adresse') . '"' : ''}}>
                                            <b-input type="text" required name="adresse"></b-input>
                                        </b-field>
                                        <b-field>
                                            <b-tooltip
                                                    label="Activer ou desactiver la visibilité de l'adresse du producteur sur le site">
                                                <b-switch
                                                        v-model="addressState"
                                                        name="adresse_visible"
                                                        true-value="Visible"
                                                        false-value="Non Visible">@{{ addressState }}
                                                </b-switch>
                                            </b-tooltip>
                                        </b-field>

                                        <b-field label="Numéro de téléphone"
                                                {{ $errors->has('telephone') ? 'type="is-danger" message="' . $errors->first('telephone') . '"' : ''}}>
                                            <b-input name="telephone" required
                                                     value="{{ old('telephone') }}"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column is-half-desktop">
                                        <b-field
                                                label="Parlez-nous du producteur"
                                                {{ $errors->has('bio') ? 'type="is-danger" message="' . $errors->first('bio') . '"' : ''}}>
                                            <b-input type="textarea" required maxLength="300" placeholder="Une petite description ?"
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
                                                          type="is-info">
                                                    @{{ accountState }}
                                                </b-switch>
                                            </div>
                                        </div>
                                        <div class="column">
                                            <button type="submit" class="button is-primary is-pulled-right">Créer le compte</button>
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
