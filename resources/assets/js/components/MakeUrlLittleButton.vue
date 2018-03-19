<template>
    <p class="control">
        <a @click="createUrl" id="show-add-url-form" class="button is-primary">
            <span class="icon"><i class="fa fa-plus"></i></span>
            <span>Make Little Url</span>
        </a>
    </p>
</template>

<script>
    export default {
        data () {
            return {
                isLoading: false,
                url: '',
            }
        },
        methods: {
            createUrl () {
                this.$swal({
                    title: 'Create Url',
                    input: 'url',
                    showCancelButton: true,
                    confirmButtonText: 'Make Little',
                    showLoaderOnConfirm: true,
                    preConfirm: (url) => {
                        return new Promise((resolve) => {
                            axios.post('/url/create', { 'url' : url })
                                .then(response => resolve())
                                .catch(error => this.$swal.showValidationError(error.response.data.message));
                        });
                    },
                    allowOutsideClick: () => !swal.isLoading()
                }).then((result) => {
                    if (result.value) {
                        this.$swal({
                            title: 'Success!',
                            text: 'URL Created.',
                            type: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            }
        }
    }
</script>
