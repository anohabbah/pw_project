<script>
    import imageUpload from 'vue-image-crop-upload';

    export default {
        props: ['avatar', 'subject'],
        data() {
            return {
                producer: this.subject,
                show: false,
                imgDataUrl: this.avatar,
                nom: this.subject.nom,
                email: this.subject.email,
                phone: this.subject.telephone,
                desc: this.subject.bio,
                adresse: this.subject.adresse,
                marker: {
                    lat: parseFloat(this.subject.latitude),
                    lng: parseFloat(this.subject.longitude)
                },
                isLoading: false,
                isEditName: false,
                isEditingDesc: false,
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
            performUpdateName() {
                this.isLoading = true;
                this.producer.nom = this.nom;
                this.producer.telephone = this.phone;

                axios.put(App.producerUpdate, this.producer)
                    .then(({data}) => {
                        this.isLoading = false;
                        this.isEditName = false;
                        this.toast();
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },
            performUpdateBio() {
                this.isLoading = true;
                this.producer.bio = tinyMCE.activeEditor.getContent();

                axios.put(App.producerUpdate, this.producer)
                    .then(({data}) => {
                        this.desc = this.producer.bio;
                        this.isLoading = false;
                        this.isEditingDesc = false;
                        this.toast();
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },
            performUpdateAdresse() {
                this.producer.adresse = this.adresse;
                this.producer.latitude = this.marker.lat;
                this.producer.longitude = this.marker.lng;

                this.isLoading = true;
                axios.put(App.producerUpdate, this.producer)
                    .then(({data}) => {
                        this.isLoading = false;
                        this.toast()
                    })
            },
            setPlace(place) {
                this.marker.lat = place.geometry.location.lat();
                this.marker.lng = place.geometry.location.lng();

                this.$snackbar.open({
                    message: "Voulez-vous enregistrer cette nouvelle adresse ?",
                    type: 'is-info',
                    position: 'is-bottom',
                    actionText: 'OK',
                    duration: 10000,
                    onAction: () => {
                        this.performUpdateAdresse();
                    }
                })
            },
            toast() {
                this.$toast.open({message: 'Mise à jour réussie !', type: 'is-success'})
            }
        }
    }
</script>
