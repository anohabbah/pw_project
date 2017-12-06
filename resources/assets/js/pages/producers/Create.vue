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
                default: 'Non Activé'
            },
            lat: {
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
                position: {
                    lng: this.lng,
                    lat: this.lat,
                },
                id_media: this.profileAvatar,
                accountState: this.actif === 'on' ? 'Activé' : 'Non Activé',
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
                toast("Redimensionnement réussi.");
            },
            cropUploadSuccess(jsonData, field) {
                this.id_media = jsonData.id_media;
                toast('Téléchargement de la photo réussi.')
            },
            cropUploadFail(status, field) {
                console.log(status);
            },
            setPlace(place) {
                this.position.lat = place.geometry.location.lat();
                this.position.lng = place.geometry.location.lng();
            }
        }
    }
</script>