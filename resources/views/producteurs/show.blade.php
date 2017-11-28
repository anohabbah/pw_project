@extends('layouts.app', ['title' => 'Producteurs', 'subtitle' => 'Profil de: ' . $producteur->nom])

@section('content')
    <prod-show-view
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
                                <a href="#" class="card-header-icon" aria-label="more options">
                                    <b-tooltip label="Modifier Profil" position="is-bottom" multilined>
                                        <b-icon icon="edit"></b-icon>
                                    </b-tooltip>
                                </a>
                            </div>
                            <div class="card-content">
                                <div class="content">
                                    <div class="avatar-container">
                                        <img :src="imgDataUrl"
                                             alt="{{ $producteur->nom }}"
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
                                            <div class="container">
                                                <h1 class="title">{{ $producteur->nom }}</h1>
                                                <h2 class="subtitle">{{ $producteur->email }}</h2>
                                            </div>
                                        </div>
                                    </section>
                                </div>
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
