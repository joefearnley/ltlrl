@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="container content-page">
            @if (count($errors) > 0)
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-md-8 col-md-offset-2 align-center">
                    <h1>Little URL</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="url-form" action="url/create" method="post">
                                {!! csrf_field() !!}
                                <div class="input-group input-group-lg">
                                    <input type="text" name="url" id="url" class="form-control input-lg" placeholder="Enter Url and ...">
                                    <span class="input-group-btn">
                                        <button id="submit-form" class="btn btn-default ladda-button" data-style="expand-left"><span class="ladda-label">Make it Little</span></button>
                                    </span>
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
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>@{{ error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </script>

    <script id="response-message-template" type="x-tmpl-mustache">
        <div class="row result">
            <div class="col-md-8 col-md-offset-2">
                <h4>URL has been made little! - <strong>@{{ link }}</strong></h4>
            </div>
        </div>
    </script>

    <script>
        var MainForm = {
            init: function() {
                this.bindEvents();
            },
            bindEvents: function() {
                $('#submit-form').click(this.submitForm);
            },
            submitForm: function(e) {
                e.preventDefault();
                var l = Ladda.create(document.querySelector('#submit-form'));
	 	        l.start();

                var data = $('#url-form').serialize();
                $.post('url/create', data)
                    .success(function(response) {
                        if (response.success) {
                            var template = $('#response-message-template').html();
                            var html = Mustache.render(template, response.url);
                            $('#response-message').html(html);
                        } else {
                            var template = $('#error-message-template').html();
                            var html = Mustache.render(template, { 'error' : response.message});
                            $('#response-message').html(html);
                        }
                    }, 'json')
                    .always(function() {
                         l.stop();
                    });

                return false;
            }
        };

        $(function() {
            MainForm.init();
        });
    </script>
@endsection
