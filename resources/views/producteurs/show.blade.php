@extends('layouts.app', ['title' => 'Producteurs', 'subtitle' => 'Profil de: ' . $producteur->nom])

@section('content')
    <div class="colums">
        <div class="column">
            <div class="columns">
                <div class="column is-half-desktop is-offset-one-quarter-desktop">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-title">
                                Photo de Profil
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="content">
                                <div class="avatar-container" style="display: block; width: 200px; margin: 0 auto;">
                                    <img src="{{ asset('storage/' . $producteur->media->url) }}"
                                         alt="{{ $producteur->nom }}" class="profile-pic is-centered img-circle">
                                </div>
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
@endsection
