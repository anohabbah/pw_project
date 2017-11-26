<script>
    import imageUpload from 'vue-image-crop-upload';

    export default {
        props: {
            adresseVisible: {
                type: String,
                default: 'Non Visible'
            },
            actif: {
                type: String,
                default: 'Compte Non Activé'
            },
            lati: {
                type: Number,
                default: null
            },
            lng: {
                type: Number,
                default: null
            },
            profileAvatar: {
                type: Number,
                default: null
            }
        },
        data() {
            return {
                lat: this.lati,
                long: this.lng,
                id_media: this.profileAvatar,
                accountState: this.actif === 'on' ? 'Compte Activé' : 'Compte Non Activé',
                addressState: this.adresseVisible === 'on' ? 'Visible' : 'Non Visible',
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