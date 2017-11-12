@extends('layouts.app', ['title' => 'Tableau de Bord', 'subtitle' => 'Tableau de Bord'])

@section('content')
    <div class="content">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    Les Statistiques du Site
                </p>
            </header>
            <div class="card-content">
                <div class="content">
                    <nav class="level">
                        <div class="level-item has-text-centered">
                            <div>
                                <p class="heading">Tweets</p>
                                <p class="title">3,456</p>
                            </div>
                        </div>
                        <div class="level-item has-text-centered">
                            <div>
                                <p class="heading">Following</p>
                                <p class="title">123</p>
                            </div>
                        </div>
                        <div class="level-item has-text-centered">
                            <div>
                                <p class="heading">Followers</p>
                                <p class="title">456K</p>
                            </div>
                        </div>
                        <div class="level-item has-text-centered">
                            <div>
                                <p class="heading">Likes</p>
                                <p class="title">789</p>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
