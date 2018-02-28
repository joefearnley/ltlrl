<template>
    <div class="column m-t-md">
        <h1 class="title">Urls</h1>
        <li v-for="url in urls" :key="url.id">
            <section>
                <div class="columns">
                    <div class="column is-3">
                        <div class="is-size-7 m-b-sm">Mar 2, 2018</div>
                        <div class="field has-addons">
                            <div class="control">
                                <input class="input" type="text" placeholder="Find a repository" value="lttrl.pw/kdf8eir">
                            </div>
                            <div class="control">
                                <button class="button is-success tooltip" data-tooltip="Copy to Clipboard"><i class="fas fa-clipboard"></i></button>
                            </div>
                        </div>
                        <strong>Url:</strong> google.com <br>
                        <strong>Clicks:</strong> 32<br>
                    </div>
                    <div class="column is-7">
                        <canvas class="click-chart-" height="100"></canvas>
                    </div>
                    <div class="column is-3 is-pulled-right">
                        <a class="button is-info is-small"><i class="far fa-edit fa-btn"></i> Edit</a>
                        <a class="button is-danger is-small"><i class="far fa-trash-alt fa-btn"></i> Delete</a>
                    </div>
                </div>
            </section>
        </li>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                urls: []
            }
        },
        mounted() {
            console.log('getting urls....');
            this.getUrls();
        },
        methods: {
            getUrls () {
                axios.get('/account/urls/')
                    .then(response => this.renderResults(response))
                    .catch(error => console.log(error));
            },
           renderResults (response) {
                console.log(response);
                this.urls = response.data.urls;
            }
        }
    }
</script>
