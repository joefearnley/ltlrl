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
                                <input type="text" id="name" class="input" name="name" placeholder="Name" v-model="name" required>
                                <div class="help-block with-errors" v-show="nameError">{{ nameErrorMessage }}</div>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">E-Mail Address</label>
                            <div class="control">
                                <input type="email" id="email" class="input" name="email"  placeholder="E-Mail Address" v-model="email" required>
                                <div class="help-block with-errors" v-show="emailError">{{ emailErrorMessage }}</div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <button class="button is-primary" @click="updateInformation()">
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
                emailErrorMessage: ''
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
                axios.post('/api/account/update-personal-info')
                    .then(response => {
                        // swal personal information updated......
                    })
                    .catch(error => this.showErrorMessage(error.response.data.message));
            },
            showErrorMessage (message) {
                console.log(message);
            }
        }
    }
</script>
