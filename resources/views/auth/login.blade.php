@extends('layouts.app')

@section('content')
<!-- 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
 -->
<div class="container">
    <div class="columns">
        <div class="column is-8 is-offset-2">
            <div class="panel">
                <p class="panel-heading">Login</p>
                <div class="panel-block">
                    <form role="form" method="POST" action="{{ url('/login') }}">
                        {!! csrf_field() !!}
                        <div class="field is-horizontal">
                            <div class="field-label is-normal">
                                <label class="label">Email Address</label>
                            </div>
                            <div class="control">
                                <input class="input" type="text" name="email">
                            </div>
                        </div>
                        <div class="field is-horizontal">
                            <div class="field-label is-normal">
                                <label class="label">Password</label>
                            </div>
                            <p class="control">
                                <input class="input" type="password" name="password">
                            </p>
                        </div>
                        <div class="field is-horizontal">
                            <div class="control">
                                <label class="checkbox">
                                    <input type="checkbox" name="remember"> Remember Me</a>
                                </label>
                            </div>
                        </div>
                        <div class="field">
                            <p class="control">
                                <button class="button is-primary">
                                    <span class="icon is-small"><i class="fas fa-sign-in"></i></span>
                                    <span>Login</span>
                                </button>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">


            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i>Login
                                </button>

                                <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
@endsection
