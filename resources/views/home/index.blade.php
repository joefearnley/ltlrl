@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="container content-page">
            <div id="error-message">
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2 align-center">
                    <h1>Little URL</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="url-form" action="url/create" method="post" class="form-horizontal">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label id="url-error-message" class="control-label" for="url"></label>
                                    <div class="input-group input-group-lg">
                                        <input type="text" name="url" id="url" class="form-control input-lg" placeholder="Enter Url and ...">
                                        <span class="input-group-btn">
                                            <button id="submit-form" class="btn btn-default ladda-button" data-style="expand-left"><span class="ladda-label">Make it Little</span></button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="response-message">
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script id="error-message-template" type="x-tmpl-mustache">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="alert alert-danger">
                    @{{ errorMessage }}
                </div>
            </div>
        </div>
    </script>

    <script id="response-message-template" type="x-tmpl-mustache">
        <div class="row result">
            <div class="col-md-8 col-md-offset-2">
                <h4>
                    URL has been made little! - <strong>@{{ link }}</strong>
                    <button id="copy-url" class="btn btn-success margin-left" data-link="@{{ link }}">
                        <i class="fa fa-clipboard" aria-hidden="true"></i> Copy to Clipboard
                    </button>
                </h4>
            </div>
        </div>
    </script>

    <script>
        var UrlForm = {
            init: function() {
                this.bindEvents();
            },
            bindEvents: function() {
                $(document).on('click', '#submit-form', this.submitForm);

                var clipboard = new Clipboard('#copy-url', {
                    text: function (trigger) {
                        return $(trigger).data('link');
                    }
                });

                clipboard.on('success', function(e) {
                    e.clearSelection();
                    $('#copy-url').notify('Success!', {
                        className: 'success',
                        position: 'right',
                        autoHideDelay: 2000,
                        arrowShow: false,
                        gap: 10
                    });
                });
            },
            submitForm: function(e) {
                e.preventDefault();

                var self = UrlForm;
                self.hideError();
                var l = Ladda.create(document.querySelector('#submit-form'));
	 	        l.start();

                var data = $('#url-form').serialize();
                $.post('url/create', data)
                    .success(function(response) {
                        self.renderResponse('#response-message-template', '#response-message', response.url);
                    }, 'json')
                    .error(function(response) {
                        self.showError(response.responseJSON.url[0]);
                    })
                    .always(function() {
                         l.stop();
                    });

                return false;
            },
            renderResponse: function(templateSelector, messageSelector, data) {
                var template = $(templateSelector).html();
                var html = Mustache.render(template, data);
                $(messageSelector).html(html);
            },
            showError: function(message) {
                var $formButton = $('#submit-form');
                $formButton.closest('.form-group').addClass('has-error');
                $formButton.addClass('btn-danger');
                $('#url-error-message').text(message);
            },
            hideError: function() {
                var $formButton = $('#submit-form');
                $formButton.closest('.form-group').removeClass('has-error');
                $formButton.removeClass('btn-danger');
                $('#url-error-message').text('');
            }
        };

        $(function() {
            UrlForm.init();
        });
    </script>
@endsection
