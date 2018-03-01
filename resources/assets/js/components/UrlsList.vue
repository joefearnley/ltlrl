<template>
    <div class="column m-t-md">
        <h1 class="title">Urls</h1>
        <section v-for="url in urls" :key="url.id">
            <div class="columns">
                <div class="column is-4">
                    <div class="is-size-7 m-b-sm">{{ url.formatted_date }}</div>
                    <div class="field has-addons">
                        <div class="control is-expanded">
                            <input class="input" type="text" placeholder="Find a repository" :value="url.short_url.slice(7)">
                        </div>
                        <div class="control">
                            <button v-clipboard="url.short_url" class="button is-success is-outlined tooltip" @success="copyToClipboard" @error="copyToClipboardError" data-tooltip="Copy to Clipboard">
                                <i class="fas fa-clipboard"></i>
                            </button>
                        </div>
                    </div>
                    <p><strong>Url:</strong> {{ url.url }} </p>
                    <p><strong>Clicks:</strong> {{ url.click_count }}</p>
                    <p class="m-t-md">
                        <a class="button is-info is-small is-outlined"><i class="far fa-edit fa-btn"></i> Edit</a>
                        <a class="button is-danger is-small is-outlined"><i class="far fa-trash-alt fa-btn"></i> Delete</a>
                    </p>
                </div>
                <div class="column is-7">
                    <canvas class="click-chart" height="100"></canvas>
                </div>
            </div>
            <hr>
        </section>
    </div>
</template>

<script>
    import { Bar } from 'vue-chartjs'

    export default {
        extends: Bar,
        data () {
            return {
                urls: []
            }
        },
        mounted() {
            this.getUrls();
        },
        methods: {
            getUrls () {
                axios.get('/api/account/urls/')
                    .then(response => this.renderResults(response))
                    .catch(error => console.log(error));
            },
           renderResults (response) {
                this.urls = response.data.urls;

                this.urls.forEach(url => this.getStats(url));
            },
            getStats(url) {
                axios.get(`urls/stats/${url.id}`)
                    .then(response => this.renderChart(response))
                    .catch(error => console.log(error));
            },
            renderChart(url) {

            },
            edit() {
            },
            delete() {
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
