<script>
    import imageUpload from 'vue-image-crop-upload';

    export default {
        props: ['avatar'],
        data() {
            return {
                show: false,
                imgDataUrl: this.avatar,
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
            }
        }
    }
</script>