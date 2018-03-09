<template>
    <div class="column is-9 m-t-md">
        <section class="hero is-primary welcome is-small">
            <div class="hero-body">
                <div class="container">
                    <h1 class="title">Hello, {{ user.name }}.</h1>
                    <h2 class="subtitle">I hope you are having a great day!</h2>
                </div>
            </div>
        </section>
        <section class="info-tiles stats">
            <div class="tile is-ancestor has-text-centered">
                <div class="tile is-parent">
                    <article class="tile is-child box">
                        <p class="title">{{ user.daysMakingUrlsLittle }}</p>
                        <p class="subtitle">Days Making Urls Little</p>
                    </article>
                </div>
                <div class="tile is-parent">
                    <article class="tile is-child box">
                        <p class="title">{{ user.urlsMade }}</p>
                        <p class="subtitle">Urls Made Little</p>
                    </article>
                </div>
                <div class="tile is-parent">
                    <article class="tile is-child box">
                        <p class="title">{{ user.urlsClickedOn }}</p>
                        <p class="subtitle">Urls Clicked On</p>
                    </article>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                user: {},
                isLoading: false,
            }
        },
        mounted() {
            this.getUserInfo();
        },
        methods: {
            getUserInfo () {
                axios.get(`/user`)
                    .then(response => this.renderResults(response.data.user))
                    .catch(error => console.log(error));
            },
           renderResults (url) {
                this.user = user;
                this.isLoading = false;
            }
        }
    }
</script>
