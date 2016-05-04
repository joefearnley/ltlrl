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
                {{--<h1>Dashboard</h1>--}}
                {{--<div class="row placeholders">--}}
                    {{--<div class="col-xs-6 col-sm-3 placeholder">--}}
                        {{--<img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=="--}}
                             {{--width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">--}}
                        {{--<h4>Label</h4>--}}
                        {{--<span class="text-muted">Something else</span>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-6 col-sm-3 placeholder">--}}
                        {{--<img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=="--}}
                             {{--width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">--}}
                        {{--<h4>Label</h4>--}}
                        {{--<span class="text-muted">Something else</span>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-6 col-sm-3 placeholder">--}}
                        {{--<img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=="--}}
                             {{--width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">--}}
                        {{--<h4>Label</h4>--}}
                        {{--<span class="text-muted">Something else</span>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-6 col-sm-3 placeholder">--}}
                        {{--<img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=="--}}
                             {{--width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">--}}
                        {{--<h4>Label</h4>--}}
                        {{--<span class="text-muted">Something else</span>--}}
                    {{--</div>--}}
                {{--</div>--}}

                <urls list="{{ Auth::user()->urls }}"></urls>

                <template id="urls-template">
                    <h2 class="sub-header">Urls</h2>
                    <ul class="list-group">
                        <li class="list-group-item" v-for="url in list">
                            <div class="row">
                                <div class="col-sm-8">
                                    <strong>Url:</strong> @{{ url.url }}<br>
                                    <strong>Clicks:</strong> @{{ url.clicks }}
                                </div>
                                <div class="col-sm-4">
                                    <button class="btn btn-primary"><i class="fa fa-pencil"></i> Edit</button>
                                    <button class="btn btn-danger @click="delete(url)"><i class="fa fa-trash"></i> Delete</button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </template>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.21/vue.min.js"></script>
    <script>
        Vue.component('urls', {
            template: '#urls-template',
            data: function() {
                return {
                    list: []
                }
            },
            created: function() {
                $.getJSON('/api/account/urls', function(urls) {
                    this.list = urls;
                }.bind(this));
            },
            methods: {
                delete: function(url) {
                    this.list.$remove(url);
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