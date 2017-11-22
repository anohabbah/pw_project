@extends('layouts.app', ['title' => 'Catégories', 'subtitle' => 'Liste des catégories'])

@section('content')
    <div class="columns">
        <div class="column is-half-desktop">
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">
                        Les Catégories
                    </p>

                </header>
                <div class="card-content">
                    <div class="content">
                        <table class="table is-narrow is-hoverable">
                            <thead>
                            <tr>
                                <th width="40">#</th>
                                <th>Catégorie</th>
                                <th>Sous Catégorie</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr class="is-selected">
                                    <td>{{ $category->id_categorie }}</td>
                                    <td colspan="2">{{ $category->nom_categorie }}</td>
                                    <td>
                                        <b-tooltip label="Modifier">
                                            <a href="{{ route('categories.edit', $category) }}"><b-icon icon="mode_edit"></b-icon></a>
                                        </b-tooltip>

                                        <b-tooltip label="Aperçu">
                                            <a href="#">
                                                <b-icon icon="remove_red_eye"></b-icon>
                                            </a>
                                        </b-tooltip>

                                        <b-tooltip label="Supprimer">
                                            <a href="{{ route('categories.destroy', $category) }}"
                                               onclick="event.preventDefault();document.getElementById('delete-form-' + '{{ $category->id }}').submit();">
                                                <b-icon icon="delete_forever"></b-icon>
                                            </a>
                                            <form id="delete-form-{{ $category->id_categorie }}" action="{{ route('categories.destroy', $category) }}" method="POST"
                                                  style="display: none;">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                            </form>
                                        </b-tooltip>
                                    </td>
                                </tr>

                                @foreach($category->children as $child)
                                    <tr>
                                        <td>{{ $child->id_categorie }}</td>
                                        <td></td>
                                        <td>{{ $child->nom_categorie }}</td>
                                        <td>
                                            <b-tooltip label="Modifier">
                                                <a href="{{ route('categories.edit', $child) }}"><b-icon icon="mode_edit"></b-icon></a>
                                            </b-tooltip>

                                            <b-tooltip label="Aperçu">
                                                <a href="#">
                                                    <b-icon icon="remove_red_eye"></b-icon>
                                                </a>
                                            </b-tooltip>

                                            <b-tooltip label="Supprimer">
                                                <a href="{{ route('categories.destroy', $child) }}"
                                                   onclick="event.preventDefault();document.getElementById('delete-form-' + '{{ $child->id }}').submit();">
                                                    <b-icon icon="delete_forever"></b-icon>
                                                </a>
                                                <form id="delete-form-{{ $child->id_categorie }}" action="{{ route('categories.destroy', $child) }}" method="POST"
                                                      style="display: none;">
                                                    {{ csrf_field() }}
                                                    {{ method_field('delete') }}
                                                </form>
                                            </b-tooltip>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="card-footer-item">
                        {!! $categories->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
