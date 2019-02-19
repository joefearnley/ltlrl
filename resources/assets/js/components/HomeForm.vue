<profile dusk="home-form-component"></profile>

<template>
    <div class="container home-page">
        <div class="columns">
            <div class="column is-6 is-offset-3">
                <div class="result align-center" :class="{ 'is-hidden': !showResult }">
                    <h3>Your URL has been made little!</h3>
                    <label class="label align-left">Copy to Clipboard</label>
                    <div class="field has-addons has-addons-centered">
                        <div class="control little-url-copy-control">
                            <input class="input" type="text" v-model="shortUrl">
                        </div>
                        <div class="control">
                            <button v-clipboard="shortUrl" @success="copyToClipboard" @error="copyToClipboardError" class="button tooltip" data-tooltip="Copy to Clipboard">
                                <i class="fas fa-clipboard"></i>
                            </button>
                        </div>
                    </div>
                    <label class="label align-left">Text to Phone</label>
                    <div class="field has-addons has-addons-centered">
                        <div class="control little-url-copy-control">
                            <input class="input" type="text" v-model="textMessageNumber" placeholder="XXX-XXX-XXXX">
                        </div>
                        <div class="control">
                            <button @success="" @error="" class="button tooltip" data-tooltip="Text Message">
                                <i class="fas fa-mobile-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <form>
                    <div class="field has-addons create-url-input">
                        <p class="control is-expanded">
                            <input class="input" :class="{ 'is-danger': hasError }"  id="url" type="text" placeholder="Enter URL and ..." v-model="url">
                        </p>
                        <p class="control">
                            <a id="make-url-little" class="button is-primary" @click="createUrl" :class="{ 'is-loading': isLoading }">
                                Make it Little
                            </a>
                        </p>
                    </div>
                    <p class="help is-danger create-url-error" v-if="hasError">{{ errorMessage }}</p>
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
                isLoading: false,
                url: '',
                hasError: false,
                shortUrl: '',
                errorMessage: ''
            }
        },
        methods: {
            createUrl () {
                this.showResult = false;
                this.isLoading = true;
                this.hasError = false;
                axios.post('/url/create', { 'url' : this.url })
                    .then(response => this.renderResults(response))
                    .catch(error => this.displayError(error));
            },
            renderResults (response) {
                this.shortUrl = response.data.short_url.slice(7);
                this.showResult = true;
                this.isLoading = false;
            },
            displayError (error) {
                this.showResult = false;
                this.isLoading = false;
                this.hasError = true;
                this.errorMessage = error.response.data.errors.url[0];
            },
            copyToClipboard(e) {
                this.$swal({
                    title: 'Success!',
                    text: 'URL Copied to Clipboard.',
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

<style scoped>
    p.control.is-expanded {
        margin-bottom: 0;
    }
</style>
