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
                axios.get('/producteurs/fetch')
                    .then(({data}) => {
                        this.producers = data;
                        this.isLoading = false;
                    });
            },
            showProducerRoute(id) {
                return '/producteurs/' + id;
            },
            editProducerRoute(id) {
                return '/producteurs/' + id + '/edit';
            },
            destroy(id) {
                axios.delete('producteurs/' + id)
                    .then(({data}) => {
                        _.forEach(this.producers, (producer, index) => {
                            if (producer.id_producteur === id) {
                                this.producers.splice(index, 1);
                            }
                        });

                        this.$toast.open({message: "Compte supprimé !", type: "is-success"})
                    });
            },
            performStatusUpdate(subject) {
                const params = {actif: subject.actif !== "1"};
                axios.put('/producteurs/' + subject.id_producteur + '/status', params)
                    .then(({data}) => {
                        _.forEach(this.producers, (producer, index) => {
                            if (producer.id_producteur === data.id_producteur) {
                                producer.actif = data.actif;
                            }
                        });

                        this.$toast.open({message: "Statut du compte modifié !", type: "is-success"})
                    });
            }
        }
    }
</script>
