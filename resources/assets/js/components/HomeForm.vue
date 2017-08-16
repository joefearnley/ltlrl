<template>
    <div class="container home-page">
        <div class="columns">
            <div class="column is-8 is-offset-2">
                <div class="result align-center" :class="{ 'is-hidden': !showResult }">
                    <p>
                        URL has been made little! - <strong>{{ url }}</strong>
                        <a class="button is-primary"><i class="fa fa-clipboard" aria-hidden="true"></i> Copy to Clipboard</a>
                    </p>
                </div>
                <form>
                    <div class="field has-addons">
                        <p class="control is-expanded"><input class="input" id="url" type="text" placeholder="Enter Url and ..." v-model="url"></p>
                        <p class="control"><a id="make-url-little" class="button is-primary" @click="createUrl">Make it Little</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                showResult: false,
                url: ''
            }
        },
        mounted() {
        },
        methods: {
            createUrl () {
                axios.post('/url/create', { 'url' : this.url })
                    .then(response => this.renderResults(response.data.url))
                    .catch(error => this.handleError(error));
            },
           renderResults (url) {
                this.url = url;
                this.showResult = true;
                swal(
                  'Oops...',
                  'Something went wrong!',
                  'error'
                )
            },
            handleError (error) {
                console.log(error);
            }
        }
    }
</script>
