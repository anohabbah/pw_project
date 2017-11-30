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
                loading: false,
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
                this.loading = true;
                this.producer.nom = this.nom;
                this.producer.telephone = this.phone;

                axios.put(App.producerUpdate, this.producer)
                    .then(({data}) => {
                        this.loading = false;
                        this.isEditName = false;
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },
            performUpdateBio() {
                this.producer.bio = tinyMCE.activeEditor.getContent();

                axios.put(App.producerUpdate, this.producer)
                    .then(({data}) => {
                        this.desc = this.producer.bio;
                        this.isEditingDesc = false;
                    })
                    .catch(err => {
                        console.log(err);
                    });
            }
        }
    }
</script>