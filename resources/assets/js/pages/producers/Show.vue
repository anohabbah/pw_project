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
                isTooltipActive: this.subject.actif !== "1",
                accountState: this.subject.actif === "1" ? 'Activé' : 'Suspendu',
                adresseVisible: this.subject.adresse_visible === "1" ? 'Visible' : 'Non Visible',
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
                toast("Photo redimensionné avec succès.");
            },
            cropUploadSuccess(jsonData, field) {
                this.id_media = jsonData.id_media;
                toast('Photo téléchargée avec succès.')
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
                        toast('Mise à jour réussie.');
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
                        toast('Mise à jour réussie.');
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
                        toast('Mise à jour réussie.')
                    })
            },
            setPlace(place) {
                this.marker.lat = place.geometry.location.lat();
                this.marker.lng = place.geometry.location.lng();

                flash({
                    message: "Voulez-vous enregistrer cette nouvelle adresse ?",
                    type: 'is-info',
                    position: 'is-bottom',
                    actionText: 'Confirmer',
                    duration: 10000,
                    callback: () => {
                        this.performUpdateAdresse();
                    }
                })
            },
            performUpdateStatus(value) {
                const actif = value === 'Activé';
                const params = {actif: actif};
                axios.put('/account/' + this.producer.id_producteur + '/status', params)
                    .then(({data}) => {
//                        this.producer = data;
                        this.isTooltipActive = false;

                        toast(actif ? "Compte activé." : "Compte suspendu.");
                    });
            },
            performupdateAddressVisibility(value) {
                const visibility = value === 'Visible';
                const params = {adresse_visible: visibility};
                axios.put('/address/' + this.producer.id_producteur + '/visibility', params)
                    .then(({data}) => {
                        toast('Visibilité de l\'adresse modifiée avec succès.');
                    });
            }
        }
    }
</script>
