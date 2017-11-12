@extends('layouts.app', ['title' => 'Tableau de Bord', 'subtitle' => 'Tableau de Bord'])

@section('content')
    <div class="content">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    Les statistiques du site
                </p>
            </header>
            <div class="card-content">
                <div class="content">
                    <nav class="level">
                        <div class="level-item has-text-centered">
                            <div>
                                <p class="heading">Produits</p>
                                <p class="title">3,456</p>
                            </div>
                        </div>
                        <div class="level-item has-text-centered">
                            <div>
                                <p class="heading">Catégories</p>
                                <p class="title">123</p>
                            </div>
                        </div>
                        <div class="level-item has-text-centered">
                            <div>
                                <p class="heading">Visites</p>
                                <p class="title">456K</p>
                            </div>
                        </div>
                        <div class="level-item has-text-centered">
                            <div>
                                <p class="heading">Producteurs</p>
                                <p class="title">789</p>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
