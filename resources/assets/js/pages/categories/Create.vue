<script>
    export default {
        props: ['data', 'current'],
        data() {
            return {
                categories: this.data,
                categorySelected: this.current
            }
        }
    }

</script>