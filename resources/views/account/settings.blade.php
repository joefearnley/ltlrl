@extends('layouts.app')

@section('content')
    <div id="app" class="container-fluid">
        <div class="row">
            @include('account.nav')
            <div class="col-sm-9 col-md-10">
                <h2>Account Settings</h2>
                <div class="row">
                    <div class="col-md-8">
                        <h3>Personal Information</h3>
                        <form id="personal-info-form" data-toggle="validator" class="form-horizontal" role="form">
                            {!! csrf_field() !!}
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <div class="form-group">
                                <label id="name-error-message" class="control-label" for="name"></label>
                                <label class="col-md-3 control-label">Name</label>
                                <div class="col-md-6">
                                    <input type="text" id="name" class="form-control" name="name" value="{{ $user->name }}" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label id="email-error-message" class="control-label" for="email"></label>
                                <label class="col-md-3 control-label">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input type="email" id="email" class="form-control" name="email" value="{{ $user->email }}" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-5 col-md-offset-7">
                                    <button id="update-personal-info" class="btn btn-primary ladda-button" data-style="expand-left">
                                        <i class="fa fa-btn fa-save"></i> Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-8">
                        <h3>Update Password</h3>
                        <form id="update-password-form" class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Confirm Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-5 col-md-offset-7">
                                    <button id="update-password-button" class="btn btn-primary ladda-button" data-style="expand-left">
                                        <i class="fa fa-btn fa-save"></i> Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>

    var personalForm = {
        init: function() {
            this.bindEvents();
        },
        bindEvents: function() {
            var self = personalForm;
            $('#personal-info-form').validator().on('submit', function (e) {
                if (!e.isDefaultPrevented()) {
                    self.savePersonalInfo(e);
                }
            });
        },
        savePersonalInfo: function(e) {
            e.preventDefault();
            var self = personalForm;
            var l = Ladda.create(document.querySelector('#update-personal-info'));
            l.start();
            var data = $('#personal-info-form').serialize();
            $.post('/api/account/update-personal-info', data)
                .success(function(response) {
                    swal({
                        title: 'Success!',
                        text: 'User Updated.',
                        type: 'success',
                        timer: 2000
                    });
                })
                .always(function() {
                    l.stop();
                });
        }
    };

    var updatePasswordForm = {
        init: function() {
            //this.bindEvents();
        },
        // bindEvents: function() {
        //     $('#update-personal-info').click(this.savePersonalInfo);
        // },
        // updatePassword: function() {
        //     var self = urlList;
        //     var l = Ladda.create(document.querySelector('#update-password-button'));
        //     l.start();
        //     var data = $('#edit-url-form').serialize();
        //
        //     $.post('/account/update-personal-info', data)
        //         .success(function(response) {
        //
        //         })
        //         .error(function(response) {
        //             self.showError(response.responseJSON.url[0]);
        //         })
        //         .always(function() {
        //             l.stop();
        //         });
        // }
    };

    $(function() {
        personalForm.init();
        updatePasswordForm.init();
    });
</script>
@endsection
