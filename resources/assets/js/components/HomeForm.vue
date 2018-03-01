<template>
    <div class="container home-page">
        <div class="columns">
            <div class="column is-8 is-offset-2">
                <div class="result align-center" :class="{ 'is-hidden': !showResult }">
                    <p><strong>Your URL has been made little!</strong></p>
                    <div class="field has-addons has-addons-centered">
                        <div class="control">
                            <input class="input" type="text" placeholder="Find a repository"  v-model="shortUrl">
                        </div>
                        <div class="control">
                            <button v-clipboard="url" @success="copyToClipboard" @error="copyToClipboardError" class="button tooltip" data-tooltip="Copy to Clipboard">
                                <i class="fas fa-clipboard"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <form>
                    <div class="field has-addons">
                        <p class="control is-expanded">
                            <input class="input" :class="{ 'is-danger': hasError }"  id="url" type="text" placeholder="Enter URL and ..." v-model="url">
                        </p>
                        <p class="control">
                            <a id="make-url-little" class="button is-primary" @click="createUrl" :class="{ 'is-loading': isLoading }">
                                Make it Little
                            </a>
                        </p>
                    </div>
                    <p class="help is-danger" v-if="hasError">Please enter valid URL</p>
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
                shortUrl: ''
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
