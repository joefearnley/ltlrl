<template>
    <div class="columns m-t-lg">
        <div class="column is-6">
            <div class="panel">
                <p class="panel-heading">
                    Update Password
                </p>
                <div class="panel-block">
                    <form role="form" v-on:submit.prevent>
                        <div class="field">
                            <label class="label">New Password</label>
                            <div class="control">
                                <input type="password" name="password" class="input" id="inputPassword" placeholder="Enter Password" v-model="password">
                                <p class="help is-danger" v-show="passwordError">{{ passwordErrorMessage }}</p>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Confirm New Password</label>
                            <div class="control">
                                <input type="password" class="input" id="inputPasswordConfirm" name="password_confirmation" placeholder="Confirm Password" v-model="passwordConfirmation">
                                <p class="help is-danger" v-show="passwordConfirmationError">{{ passwordConfirmationErrorMessage }}</p>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <button class="button is-primary" @click="updatePassword()" :class="{ 'is-loading': isLoading }">
                                    <i class="fa fa-btn fa-save"></i> Update
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
                password: '',
                passwordConfirmation: '',
                passwordError: false,
                passwordErrorMessage: '',
                passwordConfirmationError: false,
                passwordConfirmationErrorMessage: '',
                isLoading: false
            }
        },
        methods: {
            updatePassword () {
                this.isLoading = true;
                this.resetForm();
                axios.post('/api/account/update-password', {
                        password: this.password,
                        password_confirmation: this.passwordConfirmation
                    })
                    .then(response => {
                        this.$swal({
                            type: 'success',
                            title: 'Information Updated!',
                            text: 'Personal Information has been updated.',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        this.password = '';
                        this.passwordConfirmation = '';
                        this.isLoading = false;
                    })
                    .catch(error => this.showErrorMessage(error.response.data.errors));
            },
            showErrorMessage (errors) {
                if (errors.password) {
                    this.passwordError = true;
                    this.passwordErrorMessage = errors.password.pop();
                }

                this.isLoading = false;
                console.log(errors);
            },
            resetForm () {
                this.passwordError = false;
                this.passwordErrorMessage = '';
                this.passwordConfirmationError = false;
                this.passwordConfirmationErrorMessage = '';
            }
        }
    }
</script>
