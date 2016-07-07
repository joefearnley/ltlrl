@extends('layouts.app')

@section('content')
    <div id="app" class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li class="active"><a href="#"><i class="fa fa-tachometer"></i> Account Overview <span class="sr-only">(current)</span></a></li>
                    <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                </ul>
            </div>
            <div class="col-sm-9 col-md-10">
                <urls list="{{ Auth::user()->urls }}"></urls>

                <template id="urls-template">
                    <div>
                        <h2 class="sub-header">Urls</h2>
                        <div class="list-group">
                            <div class="list-group-item" v-for="url in list">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <strong>Url:</strong> @{{ url.url }}<br>
                                        <strong>Little Url:</strong> @{{ url.link }}<br>
                                        <strong>Clicks:</strong> @{{ url.clicks }} <br>
                                    </div>
                                    <div class="col-sm-4 text-right">
                                        <button class="btn btn-primary" @click="deleteUrl(url)"><i class="fa fa-pencil"></i> Edit</button>
                                        <button class="btn btn-danger" @click="deleteUrl(url)"><i class="fa fa-trash"></i> Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <template id="edit-template">
                    <div>
                        <h2 class="sub-header">Urls</h2>
                        <div class="list-group">
                            <div class="list-group-item" v-for="url in list">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <strong>Url:</strong> @{{ url.url }}<br>
                                        <strong>Little Url:</strong> @{{ url.link }}<br>
                                        <strong>Clicks:</strong> @{{ url.clicks }} <br>
                                    </div>
                                    <div class="col-sm-4 text-right">
                                        <button class="btn btn-primary" @click="deleteUrl(url)"><i class="fa fa-pencil"></i> Edit</button>
                                        <button class="btn btn-danger" @click="deleteUrl(url)"><i class="fa fa-trash"></i> Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.21/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.7.0/vue-resource.js"></script>
    <script>
        Vue.component('urls', {
            template: '#urls-template',
            data: function() {
                return {
                    list: []
                }
            },
            created: function() {
                this.fetchUrlList();
            },
            methods: {
                fetchUrlList: function() {
                    this.$http.get('/api/account/urls', function(urls) {
                        this.list = urls;
                    });
                },
                deleteUrl: function(url) {
                    this.list.$remove(url);
                },
                openEditModal: function(id) {

                }
            }
        });

        new Vue({
            el: '#app',
            data: {
                message: 'Hi Joe'
            }
        });
    </script>
@endsection
