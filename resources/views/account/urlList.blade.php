@extends('layouts.app')

@section('content')
    <div id="app" class="container-fluid" ng-app="urlList" ng-controller="UrlListController">
        <div class="row">
            @include('account.nav')
            <div class="col-sm-9 col-md-10">
                <div id="url-list">
                    <h2 class="sub-header">Urls</h2>
                    <div class="list-group col-sm-12">
                        <div class="list-group-item" ng-repeat="url in urls">
                            <div class="row">
                                <div class="col-sm-4">
                                    <strong>Url:</strong> <a href="//@{{ url }}" targer="_blank">@{{ url.url }}</a><br>
                                    <strong>Little Url:</strong> <a href="@{{ link }}" targer="_blank">@{{ url.link }}</a><br>
                                    <strong>Clicks:</strong> @{{ url.click_count }} <br>
                                    Created on <strong>@{{ url.formatted_date }}</strong><br>
                                    <button class="btn btn-success copy-url" data-url="@{{ url.link }}" ng-click="copyUrl(url.url)">
                                        <i class="fa fa-clipboard" aria-hidden="true"></i> Copy to Clipboard
                                    </button>
                                </div>
                                <div class="col-sm-5">
                                    {{-- <canvas class="click-chart-@{{ id }}" height="100"></canvas> --}}
                                </div>
                                <div class="col-sm-3 text-right">
                                    <button class="btn btn-primary edit-url" data-id="@{{ url.id }}" ng-click="editUrl(url.id)">
                                        <i class="fa fa-pencil"></i> Edit
                                    </button>
                                    <button class="btn btn-danger confirm-delete-url" data-id="@{{ id }}" ng-click="deleteUrl(url.id)">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                        <h4 ng-if="noUrlsFound">No Urls Made Little Yet.</h4>
                    </div>
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

<script src="/js/account/urlList.js"></script>
@endsection
