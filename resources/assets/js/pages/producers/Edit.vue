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
            avatar: {
                type: String,
                require: true
            }
        },
        data() {
            return {
                position: {
                    lat: this.lat,
                    lng: this.lng,
                },
                accountState: this.actif === 'on' || this.actif == 1 ? 'Activé' : 'Non Activé',
                addressState: this.adresseVisible == 1 || this.adresseVisible === 'on' ? 'Visible' : 'Non Visible',
                show: false,
                modifyPassword: false,
                imgDataUrl: this.avatar,
                passwordButtonText: 'Changer le mot de passe...',
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
                console.log(field);
            },
            cropUploadFail(status, field) {
                console.log(status);
            },
            setPlace(place) {
                this.position.lat = place.geometry.location.lat();
                this.position.lng = place.geometry.location.lng();
            },
            togglePassword() {
                this.modifyPassword = !this.modifyPassword;
                this.passwordButtonText = this.modifyPassword ? 'Annuler le changement de mot de passe' : 'Changer le mot de passe...'
            }
        }
    }
</script>