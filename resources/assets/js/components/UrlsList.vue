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
                    <p><strong>Total Clicks:</strong> {{ url.click_count }}</p>
                    <p class="m-t-md">
                        <a class="button is-info is-small is-outlined" @click="editUrl(url)"><i class="far fa-edit fa-btn"></i> Edit</a>
                        <a class="button is-danger is-small is-outlined" @click="deleteUrl(url)"><i class="far fa-trash-alt fa-btn"></i> Delete</a>
                    </p>
                </div>
                <div class="column is-7">
                    <canvas v-bind:class="[ 'click-chart-' + url.id ]"  height="100"></canvas>
                </div>
            </div>
            <hr>
        </section>
    </div>
</template>

<script>
    import Chart from 'chart.js';

    export default {
        data () {
            return {
                urls: []
            }
        },
        mounted() {
            this.getUrls();
        },
        updated() {
            this.urls.forEach(url => this.getStats(url));
        },
        methods: {
            getUrls () {
                axios.get('/api/account/urls/')
                    .then(response => this.renderResults(response))
                    .catch(error => console.log(error));
            },
           renderResults (response) {
                this.urls = response.data.urls;
            },
            getStats(url) {
                axios.get(`/url/stats/${url.id}`)
                    .then(response => this.renderChart(url, response.data))
                    .catch(error => console.log(error));
            },
            renderChart(url, clicks) {
                let labels = [];
                let data = []
                clicks.forEach(function(click) {
                    labels.push(click.date);
                    data.push(click.clicks);
                });

                new Chart(document.querySelector(`.click-chart-${url.id}`), {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Clicks',
                            backgroundColor: 'rgb(0,209,178)',
                            borderColor: 'rgb(0,209,178)',
                            fill: false,
                            data: data,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value) {
                                        if (value % 1 === 0) {
                                            return value;
                                        }
                                    }
                                }
                            }]
                        },
                        elements: {
                            line: {
                                tension: 0
                            }
                        }
                    }
                });
            },
            editUrl(url) {
                this.$swal({
                    title: 'Update Url',
                    input: 'url',
                    inputValue: url.url,
                    showCancelButton: true,
                    confirmButtonText: 'Update',
                    showLoaderOnConfirm: true,
                    preConfirm: updatedUrl => {
                        return new Promise(resolve => {
                            setTimeout(() => {
                                axios.post('/url/update', {
                                        id: url.id,
                                        url: updatedUrl
                                    })
                                    .then(response => {
                                        this.getUrls();
                                        resolve();
                                    })
                                    .catch(error => this.$swal.showValidationError(error.response.data.message));
                                resolve();
                            }, 1000);
                        });
                    },
                    allowOutsideClick: () => !this.$swal.isLoading()
                })
                .then(result => {
                    this.$swal({
                        type: 'success',
                        title: 'Url Updated!',
                        text: 'Url has been updated.',
                        showConfirmButton: false,
                        timer: 1500
                    });
                })
                .catch(error => {});
            },
            deleteUrl(url) {
                this.$swal({
                    title: 'Are you sure?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel'
                }).then(result => {
                    if (result) {
                        axios.post(`/url/delete/${url.id}`)
                            .then(response => {
                                this.$swal({
                                    type: 'success',
                                    title: 'Deleted!',
                                    text: 'Url has been deleted.',
                                    showConfirmButton: false
                                });
                                this.getUrls();
                            })
                            .catch(error => console.log(error));
                    }
                }).catch(error => {});
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
