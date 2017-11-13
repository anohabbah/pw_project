<script>
    export default {
        data() {
            return {
                categories: []
            }
        },
        created() {
            this.fetch();
        },
        methods: {
            fetch() {
                axios.get('/api/categories')
                    .then(this.promise);
            },
            promise({data}) {
                console.log(data);
            }
        }
    }
</script>