<template></template>

<script>
    export default {
        props: ['message'],
        created() {
            if (this.message) {
                this.flash(this.message);
            }

            window.events.$on(
                'flash', data => this.flash(data)
            );

            window.events.$on(
                'toast', message => this.toast(message)
            );
        },
        methods: {
            flash(data) {
                this.$snackbar.open({
                    message: data.message,
                    actionText: data.actionText,
                    type: data.type,
                    position: data.position,
                    duration: data.duration,
                    onAction: data.callback
                });
            },

            toast(message) {
                this.$toast.open({message: message, type: 'is-success'});
            }
        }
    }
</script>
