@extends('layouts.app', ['title' => 'Producteurs', 'subtitle' => 'Profile de: ' . $producteur->nom])

@section('content')
    <div class="colums">
        <div class="column">
            <div class="columns">
                <div class="column is-half-desktop is-offset-one-quarter">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-title">
                                Photo de Profile
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="content">
                                <div class="avatar-container">
                                    <img src="{{  }}" alt="{{ $producteur->nom }}" class="img-circle">
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
