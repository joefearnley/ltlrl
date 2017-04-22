@extends('layouts.app')

@section('content')
    <div class="content" ng-app="home" ng-controller="HomeController">
        <div class="container content-page home-page">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 align-center">
                    <h1>Little URL</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="url-form" class="form-horizontal">
                                {!! csrf_field() !!}
                                <div class="form-group" ng-class="{ 'has-error': errorOccured }" >
                                    <label class="control-label" for="url" ng-if="errorOccured">@{{ errorMessage }}</label>
                                    <div class="input-group input-group-lg">
                                        <input type="text" name="url" id="url" ng-model="url" class="form-control input-lg" placeholder="Enter Url and ..." ng-keyup="removeErrorMessage()">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" ng-class="{ 'btn-danger': errorOccured }" ladda="loading" data-spinner-color="#FFFFFF" data-style="expand-left" ng-click="createUrl()">
                                                Make it Little
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" ng-if="urlCreated">
                <div class="col-md-8 col-md-offset-2">
                    <h4>
                        URL has been made little! - <strong>@{{ currentUrl }}</strong>
                        <button id="copy-url" class="btn btn-success margin-left" ng-click="copyUrl()">
                            <i class="fa fa-clipboard" aria-hidden="true"></i> Copy to Clipboard
                        </button>
                    </h4>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
