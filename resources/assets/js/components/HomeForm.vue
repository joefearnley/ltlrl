<template>
    <div class="container home-page">
        <div class="columns">
            <div class="column is-8 is-offset-2">
                <form>
                    <div class="field has-addons">
                        <p class="control is-expanded"><input class="input" id="url" type="text" placeholder="Enter Url and ..."></p>
                        <p class="control"><a id="make-url-little" class="button is-primary">Make it Little</a></p>
                    </div>
                </form>
                <div class="results" >
                    <h4>
                        URL has been made little! - <strong>${url.url}</strong>
                        <a class="button is-success"><i class="fa fa-clipboard" aria-hidden="true"></i> Copy to Clipboard</a>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: {
            showResult: false
        },
        mounted() {
            console.log('HomeForm component mounted.')
        },
        methods: {
            createUrl () {
                axios.post('/url/create', { 'url' : this.urlField.value })
                    .then(response => this.showResult(response.data.url).bind(this))
                    .catch(error => this.handleError(error));
            },
           showResult (url) {
                this.results.innerHTML = this.template(url.url);
            },
            handleError(error) {
                const errorMessage = error.response.data.url[0];
            }
        }
    }
</script>
