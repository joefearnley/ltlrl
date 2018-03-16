<template>
    <div class="columns m-t-lg">
            <div class="column is-6">
            <div class="panel">
                <p class="panel-heading">
                    Update Personal Information
                </p>
                <div class="panel-block">
                    <form v-on:submit.prevent>
                        <div class="field">
                            <label class="label">Name</label>
                            <div class="control">
                                <input type="text" id="name" class="input" name="name" placeholder="Name" v-model="name">
                                <p class="help is-danger" v-show="nameError">{{ nameErrorMessage }}</p>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">E-Mail Address</label>
                            <div class="control">
                                <input type="email" id="email" class="input" name="email"  placeholder="E-Mail Address" v-model="email">
                                <p class="help is-danger" v-show="emailError">{{ emailErrorMessage }}</p>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <button class="button is-primary" @click="updateInformation()" :class="{ 'is-loading': isLoading }">
                                    <i class="fa fa-btn fa-save"></i> Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return  {
                name: '',
                email: '',
                nameError: false,
                nameErrorMessage: '',
                emailError: false,
                emailErrorMessage: '',
                isLoading: false
            }
        },
        mounted () {
            this.getInformation();
        },
        methods: {
            getInformation () {
                axios.get('/api/account/info')
                    .then(response => {
                        this.name = response.data.name;
                        this.email = response.data.email;
                    })
                    .catch(error => console.log(error.response.data.message));
            },
            updateInformation () {
                this.isLoading = true;
                this.resetForm();
                axios.post('/api/account/update-personal-info', {
                        name: this.name,
                        email: this.email
                    })
                    .then(response => {
                        this.$swal({
                            type: 'success',
                            title: 'Information Updated!',
                            text: 'Personal Information has been updated.',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        this.isLoading = false;
                    })
                    .catch(error => this.showErrorMessage(error.response.data.errors));
            },
            showErrorMessage (errors) {
                if (errors.name) {
                    this.nameError = true;
                    this.nameErrorMessage = errors.name.pop();
                }

                if (errors.email) {
                    this.emailError = true;
                    this.emailErrorMessage = errors.email.pop();
                }

                this.isLoading = false;
            },
            resetForm () {
                this.nameError = false;
                this.nameErrorMessage = '';
                this.emailError = false;
                this.emailErrorMessage = '';
            }
        }
    }
</script>
