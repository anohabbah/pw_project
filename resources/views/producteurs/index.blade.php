@extends('layouts.app', ['title' => 'Producteurs', 'subtitle' => 'Liste des comptes'])

@section('content')
    <prod-index-view inline-template>
        <div class="columns">
            <div class="column">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-title">Comptes Producteurs</div>
                    </div>
                    <div class="card-content">
                        <b-table
                                :data="producers"
                                :paginated="isPaginated"
                                :striped="isStriped"
                                :narrowed="isNarrowed"
                                :hoverable="isHoverable"
                                :per-page="perPage"
                                :loading="isLoading">

                            <template slot-scope="props">
                                <b-table-column label="Image" width="20">
                                    <img class="img-thumbnail"
                                         :src="props.row.media ? props.row.media.url : props.row.gravatar" alt="">
                                </b-table-column>

                                <b-table-column label="Nom & Prénom(s)">
                                    @{{ props.row.nom }}
                                </b-table-column>

                                <b-table-column label="Téléphone">
                                    @{{ props.row.telephone }}
                                </b-table-column>

                                <b-table-column label="Adresse">
                                    @{{ props.row.adresse }}
                                </b-table-column>

                                <b-table-column label="Actif">
                                    <a @click="performStatusUpdate(props.row)"
                                       class="has-text-success"
                                       v-if="props.row.actif == 1"><b-icon icon="check"></b-icon></a>
                                    <a @click="performStatusUpdate(props.row)"
                                       class="has-text-danger" v-else><b-icon icon="close"></b-icon></a>
                                </b-table-column>

                                <b-table-column label="Actions" width="100">
                                    <div class="block">
                                        <a :href="editProducerRoute(props.row.id_producteur)">
                                            <b-icon icon="edit"></b-icon>
                                        </a>
                                        <a :href="showProducerRoute(props.row.id_producteur)">
                                            <b-icon icon="remove_red_eye"></b-icon>
                                        </a>
                                        <a @click.prevent="destroy(props.row.id_producteur)">
                                            <b-icon icon="delete"></b-icon>
                                        </a>
                                    </div>
                                </b-table-column>
                            </template>

                            <template slot="empty">
                                <section class="section">
                                    <div class="content has-text-grey has-text-centered">
                                        <p>
                                            <b-icon
                                                    icon="sentiment_very_dissatisfied"
                                                    size="is-large">
                                            </b-icon>
                                        </p>
                                        <p>Nothing here.</p>
                                    </div>
                                </section>
                            </template>
                        </b-table>
                    </div>
                </div>
            </div>
        </div>
    </prod-index-view>
@endsection
