@extends('layouts.app', ['title' => 'Panneau d\'Administration'])

@section('content')

    <section class="hero is-primary">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    {{ config('app.name') }}
                </h1>
                <h2 class="subtitle">Panneau d'Adiministration</h2>
            </div>
        </div>
    </section>

    <div class="columns is-marginless is-centered">
        <div class="column is-one-third-desktop is-two-thirds-tablet">
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">Connexion</p>
                </header>

                <div class="card-content">
                    <form class="login-form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <b-field label="Email"
                                {{ $errors->has('email') ? 'type="is-danger" message="' . $errors->first('email') . '"' : '' }}>
                            <b-input name="email" type="email" required autofocus></b-input>
                        </b-field>


                        <b-field label="Mot de Passe"
                                {{ $errors->has('password') ? 'type="is-danger" message="' . $errors->first('password') . '"' : '' }}>
                            <b-input type="password" required name="password" password-reveal></b-input>
                        </b-field>

                        <b-field>
                            <div class="field-body">
                                <div class="field is-group">
                                    <div class="control">
                                        <b-checkbox name="remember" {{ old('remember') ? 'checked' : '' }}>Garder la
                                            session
                                        </b-checkbox>
                                        <a class="is-pulled-right" href="{{ route('password.request') }}">Mot de passe
                                            oublié?</a>
                                    </div>
                                </div>
                            </div>
                        </b-field>

                        <button type="submit" class="button is-primary" style="width: 100%">Se Connecter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
