@extends('layouts.app')

@section('content')
    <div class="content">
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
                                    <label class="control-label" for="url"></label>
                                    <div class="input-group input-group-lg">
                                        <input type="text" name="url" id="url" class="form-control input-lg" placeholder="Enter Url and ...">
                                        <span class="input-group-btn">
<!--                                             <button class="btn btn-default" ladda="loading" data-spinner-color="#FFFFFF" data-style="expand-left">
                                                Make it Little
                                            </button> -->
                                            <button id="make-url-little" class="btn btn-default ladda-button" data-style="expand-left" data-spinner-color="#fff">
                                                <span class="ladda-label">Make it Little</span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row results">
                <div class="col-md-8 col-md-offset-2">
                    <h4>
                        URL has been made little! - <strong>@{{ currentUrl }}</strong>
                        <button id="copy-url" class="btn btn-success margin-left">
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
