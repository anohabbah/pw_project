@extends('layouts.app', ['title' => 'Producteurs', 'subtitle' => 'Profil de: ' . $producteur->nom])

@section('content')
    <prod-show-view
            :subject="{{ $producteur }}"
            {{ $producteur->media
                ? ':avatar="' . $producteur->media->url .'"'
                : ':avatar="https://www.gravatar.com/avatar/' . md5($producteur->email) . '?s=100"' }}
            inline-template v-cloak>
        <div class="colums">
            <div class="column">
                <div class="columns">
                    <div class="column is-half-desktop is-offset-one-quarter-desktop">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-header-title">
                                    Photo de Profil
                                </div>
                                <a @click="isEditName = !isEditName" class="card-header-icon" aria-label="more options">
                                    <b-tooltip label="Modifier Profil" position="is-left">
                                        <b-icon icon="edit"></b-icon>
                                    </b-tooltip>
                                </a>
                            </div>
                            <div class="card-content">
                                <div>
                                    <div class="avatar-container">
                                        <img :src="imgDataUrl"
                                             :alt="nom"
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

                                    <section class="hero has-text-centered">
                                        <div class="hero-body p-t-5 p-b-5">
                                            <div v-if="!isEditName">
                                                <h1 class="title" v-text="nom"></h1>
                                                <h2 class="subtitle m-b-5" v-text="email"></h2>
                                                <h2 class="subtitle m-t-0" v-text="phone"></h2>
                                            </div>
                                            <div v-else>
                                                <b-field>
                                                    <b-input v-model="nom" :loading="loading"></b-input>
                                                </b-field>
                                                <b-field>
                                                    <b-input v-model="email" disabled></b-input>
                                                </b-field>
                                                <b-field>
                                                    <b-input v-model="phone" :loading="loading"></b-input>
                                                </b-field>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                            <div class="card-footer" v-if="isEditName">
                                <a @click="isEditName = false" class="card-footer-item">Annuler</a>
                                <a class="card-footer-item" @click="performUpdateName">Enregistrer</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="columns">
                    <div class="column is-half-desktop is-offset-one-quarter-desktop">
                        <div class="card">
                            <header class="card-header">
                                <div class="card-header-title">Description du profil</div>

                                <a @click="isEditingDesc = !isEditingDesc" class="card-header-icon" aria-label="more options">
                                    <b-tooltip label="Modifier la description" position="is-left">
                                        <b-icon icon="edit"></b-icon>
                                    </b-tooltip>
                                </a>
                            </header>
                            <div class="card-content">
                                <div class="content">
                                    <div class="desc-body" v-html="desc" v-if="!isEditingDesc"></div>

                                    <form id="ajaxForm">
                                        <div class="desc-form" v-show="isEditingDesc">
                                            <b-field>
                                                <b-input
                                                        type="textarea"
                                                        v-model="desc"
                                                        :value="desc"
                                                        placeholder="Décrire en quelques mots le producteur."
                                                        name="bio"></b-input>
                                            </b-field>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div v-if="isEditingDesc" class="card-footer">
                                <a @click="isEditingDesc = false" class="card-footer-item">Annuler</a>
                                <a @click.prevent="performUpdateBio" class="card-footer-item">Enregistrer</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-header-title">
                            Producteurs
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="content">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </prod-show-view>
@endsection

@push('styles')
    <script>
        App = {!! json_encode([
            'producerUpdate' => route('producteurs.update', $producteur),
            'baseDir' => public_path()
        ]) !!}
    </script>
@endpush

@push('scripts')
    <script src="{{ asset('js/tinymce/tiny_mce.js') }}"></script>
    <script src="{{ asset('js/tinymce.inc.js') }}"></script>
    <script src="{{ asset('js/tinymce_loader.js') }}"></script>
@endpush
