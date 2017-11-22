<script>
    export default {
        props: ['data', 'current'],
        data() {
            return {
                categories: this.data,
                categoryId: this.current
            }
        }
    }
</script>