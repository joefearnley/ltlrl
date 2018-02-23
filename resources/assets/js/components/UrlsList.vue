<template>
    <div class="column m-t-xl">
        <section class="section">
            <div class="container">
                <div class="columns">
                    <div class="column is-2">
                        <strong>Url:</strong> <a href="" targer="_blank">url.url</a><br>
                        <strong>Little Url:</strong> <a href="" targer="_blank">asfasfd</a><br>
                        <strong>Clicks:</strong>url.click_count<br>
                        Created on <strong>url.formatted_date</strong><br>
                        <button class="btn btn-success copy-url" data-url="">
                        <i class="fa fa-clipboard" aria-hidden="true"></i> Copy to Clipboard
                        </button>
                    </div>
                    <div class="column is-5">
                        <canvas class="click-chart-" height="100"></canvas>
                    </div>
                    <div class="column is-3 is-pulled-right">
                        <a class="button is-primary"><i class="far fa-edit fa-btn"></i> Edit</a>
                        <a class="button is-danger"><i class="far fa-trash-alt fa-btn"></i> Delete</a>
                    </div>
                </div>
            </div>
        </section>
        <hr>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                urls: []
            }
        },
        methods: {
            getUrls () {
            },
           renderResults (url) {
            }
        }
    }
</script>
