<script>
    import imageUpload from 'vue-image-crop-upload';

    export default {
        props: {
            adresseVisible: {
                type: String,
                default: 'Compte Non Activé'
            },
            actif: {
                type: String,
                default: 'Compte Non Activé'
            },
            lati: {
                type: String,
                default: ''
            },
            lng: {
                type: String,
                default: ''
            },
            profileAvatar: {
                type: String,
                default: ''
            }
        },
        data() {
            return {
                lat: this.lati,
                long: this.lng,
                id_media: this.profileAvatar,
                accountState: this.actif,
                addressState: this.adresseVisible,
                show: false,
                imgDataUrl: '',
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                }
            }
        },
        components: {imageUpload},
        methods: {
            toggleShow() {
                this.show = !this.show;
            },
            cropSuccess(imageDataUrl, field) {
                this.imgDataUrl = imageDataUrl;
            },
            cropUploadSuccess(jsonData, field) {
                this.id_media = jsonData.id_media;
            },
            cropUploadFail(status, field) {
                console.log(status);
            },
            setPlace(place) {
                this.lat = place.geometry.location.lat();
                this.long = place.geometry.location.lng();
            }
        }
    }
</script>