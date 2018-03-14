<template>
    <div class="columns m-t-lg">
        <div class="column is-6">
            <div class="panel">
                <p class="panel-heading">
                    Update Password
                </p>
                <div class="panel-block">
                    <form role="form">
                        <div class="field">
                            <label class="label">New Password</label>
                            <div class="control">
                                <input type="password" name="password" class="input" id="inputPassword" placeholder="Password" required>
                                <div class="help-block">Minimum of 6 characters</div>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">New Confirm Password</label>
                            <div class="control">
                                <input type="password" class="input" id="inputPasswordConfirm" name="password_confirmation" placeholder="Confirm" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <button class="button is-primary">
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
                error: false,
                errorMessage: ''
            }
        },
        methods: {
            updatePassword () {
                axios.post('/api/account/update-password')
                    .then(response => {
                        // password updated......
                    })
                    .catch(error => showErrorMessage(error.response.data.message));
            },
            showErrorMessage (message) {
                console.log(message);
            }
        }
    }
</script>
