@extends('layouts.app')

@section('content')
    <div id="app" class="container-fluid">
        <div class="row">
            @include('account.nav')
            <div class="col-sm-9 col-md-10">
                <div id="url-list">
                </div>
            </div>
        </div>
        <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog">
        </div>
        <div id="delete-modal" class="modal fade" tabindex="-1" role="dialog">
        </div>
    </div>
@endsection

@section('scripts')
    <script id="url-list-template" type="x-tmpl-mustache">
        <h2 class="sub-header">Urls</h2>
        <div class="list-group col-sm-12 col-md-10">
        @{{#urls}}
            <div class="list-group-item">
                <div class="row">
                    <div class="col-sm-4">
                        <strong>Url:</strong> @{{ url }}<br>
                        <strong>Little Url:</strong> @{{ link }}<br>
                        <strong>Clicks:</strong> @{{ click_count }} <br>
                        Created on <strong>@{{ formatted_date }}</strong>
                    </div>
                    <div class="col-sm-4">
                        <canvas class="click-chart" height="100"></canvas>
                    </div>
                    <div class="col-sm-4 text-right">
                        <button class="btn btn-primary edit-url" data-id="@{{ id }}"><i class="fa fa-pencil"></i> Edit</button>
                        <button class="btn btn-danger confirm-delete-url" data-id="@{{ id }}"><i class="fa fa-trash"></i> Delete</button>
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
                            <label id="url-error-message" class="control-label" for="url"></label><br>
                            <input type="text" class="form-control" id="url" name="url" value="@{{ url }}">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default cancel-url-edit" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary save-url ladda-button" data-id="@{{ id }}" data-style="expand-left"><i class="fa fa-btn fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </script>

    <script id="delete-modal-template" type="x-tmpl-mustache">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p>Are you sure you want to delete this url?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default cancel-delete-edit" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger delete-url ladda-button" data-id="@{{ id }}" data-style="expand-left"><i class="fa fa-btn fa-trash"></i> Delete</button>
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
                $(document).on('click', '.confirm-delete-url', this.showDeleteConfirmation);
                $(document).on('click', '.delete-url', this.deleteUrl);

                $('#edit-modal').on('hidden.bs.modal', function() {
                    $(this).html('');
                });

                $('#delete-modal').on('hidden.bs.modal', function() {
                    $(this).html('');
                });
            },
            loadUrlList: function() {
                var self = urlList;
                $.get('/api/account/urls')
                    .success(function(response) {
                        var template = $('#url-list-template').html();
                        var html = Mustache.render(template, response);
                        $('#url-list').html(html);

                        self.createCharts(response.urls);
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
                        swal({
                            title: 'Success!',
                            text: 'Url Saved.',
                            type: 'success',
                            timer: 2000
                        });
                        $('#edit-modal').html('').modal('hide');
                        self.loadUrlList();
                    })
                    .error(function(response) {
                        self.showError(response.responseJSON.url[0]);
                    })
                    .always(function() {
                        l.stop();
                    });
            },
            showDeleteConfirmation: function() {
                var uri = '/url/' + $(this).data('id');
                $.get(uri).success(function(response) {
                    var template = $('#delete-modal-template').html();
                    var html = Mustache.render(template, response);
                    $('#delete-modal').html(html).modal('show');
                });
            },
            deleteUrl: function() {
                var self = urlList;
                var uri = '/url/delete/' + $(this).data('id');
                $.post(uri).success(function() {
                    swal({
                        title: 'Success!',
                        text: 'Url Deleted.',
                        type: 'success',
                        timer: 2000
                    });
                    $('#delete-modal').html('').modal('hide');
                    self.loadUrlList();
                });
            },
            showError: function(message) {
                $('.form-group').addClass('has-error');
                $('#url-error-message').text(message);
            },
            hideError: function() {
                $('.form-group').removeClass('has-error');
                $('#url-error-message').text('');
            },
            createCharts: function() {

                // fetch data

                $('.click-chart').each(function() {
                    new Chart($(this), {
                        type: 'line',
                        data: {
                            labels: ["", "Blue", "Yellow", "Green", "Purple", "Orange"],
                            datasets: [{
                                label: '# of Clicks',
                                data: [12, 19, 3, 5, 2, 3],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero:true
                                    }
                                }]
                            }
                        }
                    });
                });
            }
        };

        $(function() {
            urlList.init();
        });
    </script>
@endsection
