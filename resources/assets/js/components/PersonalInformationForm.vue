<template>
    <div class="columns m-t-lg">
        <div class="column is-6">
            <div class="panel">
                <p class="panel-heading">
                    Update Personal Information
                </p>
                <div class="panel-block">
                    <form>
                        <input type="hidden" name="id" value="{{ user.id }}">
                        <div class="field">
                            <label class="label">Name</label>
                            <div class="control">
                                <input type="text" id="name" class="input" name="name" placeholder="Name" v-model="name" required>
                                <div class="help-block with-errors" v-show="nameError" v-model="nameErrorMessage"></div>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">E-Mail Address</label>
                            <div class="control">
                                <input type="email" id="email" class="input" name="email"  placeholder="E-Mail Address" v-model="email" required>
                                <div class="help-block with-errors" v-show="emailError" v-model="emailErrorMessage"></div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <button class="button is-primary" @click="updateUserInformation()">
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
        data: {
            name: '',
            email: ''
            nameError: false,
            nameErrorMessage: '',
            emailError: false,
            emailErrorMessage: ''
        }
        mounted() {
            this.getUser();
        },
        methods: {
            getUserInformation () {
                axios.get('/user')
                    .then(response => {
                        console.log(response);
                    })
                    .catch(error => showErrorMessage(error.response.data.message));
            }
            updateUserInformation () {
            },
            showErrorMessage () {

            }
        }
    }
</script>
