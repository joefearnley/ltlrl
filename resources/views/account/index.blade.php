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
                <div id="url-list">
                </div>
            </div>
        </div>
        <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog">
        </div>
    </div>
@endsection

@section('scripts')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.21/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.7.0/vue-resource.js"></script> --}}

    <script id="url-list-template" type="x-tmpl-mustache">
        <h2 class="sub-header">Urls</h2>
        <div class="list-group col-sm-12 col-md-10">
        @{{#urls}}
            <div class="list-group-item">
                <div class="row">
                    <div class="col-sm-8">
                        <strong>Url:</strong> @{{ url }}<br>
                        <strong>Little Url:</strong> @{{ link }}<br>
                        <strong>Clicks:</strong> @{{ clicks }} <br>
                        Created on <strong>@{{ formatted_date }}</strong>
                    </div>
                    <div class="col-sm-4 text-right">
                        <button class="btn btn-primary edit-url" data-id="@{{ id }}"><i class="fa fa-pencil"></i> Edit</button>
                        <button class="btn btn-danger" data-id="@{{ id }}"><i class="fa fa-trash"></i> Delete</button>
                    </div>
                </div>
            </div>
            @{{/urls}}
        </div>
    </script>

    <script id="edit-modal-template" type="x-tmpl-mustache">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Edit Url</h4>
                </div>
                <div class="modal-body">
                    <form id="edit-url-form">
                        {!! csrf_field() !!}
                        <input type="hidden" class="form-control" name="id" value="@{{ id }}">
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Url:</label>
                            <input type="text" class="form-control" name="url" value="@{{ url }}">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default cancel-url-edit" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary save-url ladda-button" data-id="@{{ id }}" data-style="expand-left"><i class="fa fa-btn fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </script>

    <script>
        var urlList = {
            init: function() {
                this.bindEvents();
                this.loadUrlList();
            },
            bindEvents: function() {
                $(document).on('click', '.edit-url', this.showEditModal);
                $(document).on('click', '.save-url', this.saveUrl);
                $(document).on('click', '.deletel-url', this.showDeleteConfirmation);

                $('#edit-modal').on('hidden.bs.modal', function() {
                    $(this).html('');
                });
            },
            loadUrlList: function() {
                $.get('/api/account/urls')
                    .success(function(response) {
                        var template = $('#url-list-template').html();
                        var html = Mustache.render(template, response);
                        $('#url-list').html(html);
                    });
            },
            showEditModal: function() {
                var uri = '/url/' + $(this).data('id');
                $.get(uri).success(function(response) {
                    var template = $('#edit-modal-template').html();
                    var html = Mustache.render(template, response);
                    $('#edit-modal').html(html).modal('show');
                });
            },
            saveUrl: function() {
                var self = urlList;
                var l = Ladda.create(document.querySelector('.ladda-button'));
                l.start();
                var data = $('#edit-url-form').serialize();
                $.post('/url/update', data)
                    .success(function(response) {
                        $.notify('Url Saved!', {
                            className: 'success',
                            globalPosition: 'top center',
                            autoHideDelay: 3000
                        });
                        $('#edit-modal').html('').modal('hide');
                        self.loadUrlList();
                    })
                    .error(function(response) {
                        self.showError(response.responseJSON.url[0]);
                    }).always(function() {
                        l.stop();
                    });
            },
            showDeleteConfirmation: function() {
            },
            deleteUrl: function() {
            }
        };

        $(function() {
            urlList.init();
        });

        // Vue.component('urls', {
        //     template: '#urls-template',
        //     data: function() {
        //         return {
        //             list: []
        //         }
        //     },
        //     created: function() {
        //         this.fetchUrlList();
        //     },
        //     methods: {
        //         fetchUrlList: function() {
        //             this.$http.get('/api/account/urls', function(urls) {
        //                 this.list = urls;
        //             });
        //         },
        //         deleteUrl: function(url) {
        //             this.list.$remove(url);
        //         },
        //         openEditModal: function(id) {
        //             $('#edit-modal').modal('show');
        //         }
        //     }
        // });
        //
        // new Vue({
        //     el: '#app',
        //     data: {
        //         message: 'Hi Joe'
        //     }
        // });
    </script>
@endsection
