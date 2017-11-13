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
                                    <td>{{ $category->id }}</td>
                                    <td colspan="2">{{ $category->name }}</td>
                                    <td>
                                        <a href="#">
                                            <b-icon icon="mode_edit"></b-icon>
                                        </a>
                                        <a href="#">
                                            <b-icon icon="remove_red_eye"></b-icon>
                                        </a>
                                        <a href="#">
                                            <b-icon icon="delete_forever"></b-icon>
                                        </a>
                                    </td>
                                </tr>

                                @foreach($category->children as $child)
                                    <tr>
                                        <td>{{ $child->id }}</td>
                                        <td></td>
                                        <td>{{ $child->name }}</td>
                                        <td>
                                            <a href="#">
                                                <b-icon icon="mode_edit"></b-icon>
                                            </a>
                                            <a href="#">
                                                <b-icon icon="remove_red_eye"></b-icon>
                                            </a>
                                            <a href="#">
                                                <b-icon icon="delete_forever"></b-icon>
                                            </a>
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
