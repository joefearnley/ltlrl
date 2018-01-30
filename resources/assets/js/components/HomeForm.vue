<template>
    <div class="container home-page">
        <div class="columns">
            <div class="column is-8 is-offset-2">
                <div class="result align-center" :class="{ 'is-hidden': !showResult }">
                    <p>
                        <span>URL has been made little! - <strong>{{ url }}</strong></span>
                        <a v-clipboard="url" @success="copyToClipboard" @error="copyToClipboardError" class="button is-primary">
                            <i class="fa fa-clipboard" aria-hidden="true"></i> Copy to Clipboard
                        </a>
                    </p>
                </div>
                <form>
                    <div class="field has-addons">
                        <p class="control is-expanded"><input class="input" :class="{ 'is-danger': hasError }"  id="url" type="text" placeholder="Enter Url and ..." v-model="url"></p>
                        <p class="control"><a id="make-url-little" class="button is-primary" @click="createUrl" :class="{ 'is-loading': isLoading }">Make it Little</a></p>
                    </div>
                    <p class="help is-danger" v-if="hasError">Please enter valid URL</p>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import VueClipboards from 'vue-clipboards';
    Vue.use(VueClipboards);

    export default {
        data () {
            return {
                showResult: false,
                isLoading: false,
                url: '',
                hasError: false
            }
        },
        mounted() {
        },
        methods: {
            createUrl () {
                this.showResult = true;
                this.isLoading = true;
                this.hasError = false;
                axios.post('/url/create', { 'url' : this.url })
                    .then(response => this.renderResults(response.data.url))
                    .catch(error => this.displayError(error));
            },
           renderResults (url) {
                this.url = url;
                this.showResult = true;
                this.isLoading = false;
            },
            displayError (error) {
                this.isLoading = false;
                this.hasError = true;
            },
            copyToClipboard(e) {
                this.$swal({
                    title: 'Success!',
                    text: 'Url Copied to Clipboard.',
                    type: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
            },
            copyToClipboardError(e) {
                console.log(e);
            }
        }
    }
</script>
