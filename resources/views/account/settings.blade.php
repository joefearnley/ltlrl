@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="columns">
            @include('account.nav')
            <div class="column m-t-md">
                <h1 class="title">Account Settings</h1>
                <update-personal-information-form></update-personal-information-form>
                <div class="columns m-t-lg">
                    <div class="column is-6">
                        <div class="panel">
                            <p class="panel-heading">
                                Update Password
                            </p>
                            <div class="panel-block">
                                <form class="form-horizontal" role="form">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                    <div class="field">
                                        <label class="label">New Password</label>
                                        <div class="control">
                                            <input type="password" name="password" class="input" id="inputPassword" placeholder="Password" required>
                                            <div class="help-block">Minimum of 6 characters</div>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label class="label">New Confirm Password</label>
                                        <div class="control">
                                            <input type="password" class="input" id="inputPasswordConfirm" name="password_confirmation" placeholder="Confirm" required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="control">
                                            <button class="button is-primary">
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
    </div>
</div>
@endsection
