<script>
    export default {
        data() {
            return {
                producers: [],
                isLoading: true,
                isNarrowed: true,
                isPaginated: true,
                isHoverable: true,
                perPage: 10,
                isStriped: true
            }
        },
        created() {
            this.fetch();
        },
        methods: {
            fetch() {
                axios.get(route('producteurs.fetch'))
                    .then(({data}) => {
                        this.producers = data;
                        this.isLoading = false;
                    });
            },
            showProducerRoute(id) {
                return route('producteurs.show', id);
            },
            editProducerRoute(id) {
                return route('producteurs.show', id);
            },
            destroy(id) {
                let position;
                axios.delete(route('producteurs.destroy', id))
                    .then(({data}) => {
                        // Il n'est pas prudent de supprimer un élément dans un tableau qu'on est en train de parcourir
                        // au risque de rencontrer un comportement non determiné du programme.
                        // Le but est de parcourir le tableau, trouver l'index de l'élément qu'on veut supprimer et
                        // plus tard quand on finir de parcourir le tableau, aller à cet index et supprimer l'élément.
                        _.forEach(this.producers, (producer, index) => {
                            if (producer.id_producteur === data.id_producteur) {
                                position = index;
                            }
                        });
                        this.producers.splice(position, 1);
                        toast("Suppression du compte réussie.")
                    });
            },
            performStatusUpdate(subject) {
                const params = {actif: subject.actif !== "1"};
                axios.put(route('status.update', subject.id_producteur), params)
                    .then(({data}) => {
                        _.forEach(this.producers, (producer, index) => {
                            if (producer.id_producteur === data.id_producteur) {
                                producer.actif = data.actif;
                            }
                        });
                        toast("Modification du statut réussie.");
                    });
            }
        }
    }
</script>
