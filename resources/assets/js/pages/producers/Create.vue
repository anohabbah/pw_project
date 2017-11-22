<script>
    export default {
        data() {
            return {
                accountState: 'Compte Non Activé',
                addressState: 'Non Visible',
                dropFiles: []
            }
        },
        methods: {
            deleteDropFile(index) {
                this.dropFiles.splice(index, 1)
            }
        }
    }
</script>