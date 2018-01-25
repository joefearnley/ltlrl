@extends('layouts.app')

@section('content')
<div class="container">
    <div class="column is-4 is-offset-4">
        <h3 class="title is-4 has-text-centered">Login</h3>
        <div class="box">
            <form method="POST" action="{{ url('/login') }}">
                {!! csrf_field() !!}
                <div class="field">
                    <label class="label">Email</label>
                    <div class="control">
                        <input class="input {{ $errors->has('email') ? 'is-danger' : '' }}" type="email" name="email" value="{{ old('email') }}" autofocus="">
                    </div>
                    @if ($errors->has('email'))
                        <p class="help is-danger">{{ $errors->first('email') }}</p>
                    @endif
                </div>
                <div class="field">
                    <label class="label">Password</label>
                    <div class="control">
                        <input class="input {{ $errors->has('password') ? 'is-danger' : '' }}" type="password" name="password">
                    </div>
                    @if ($errors->has('password'))
                        <p class="help is-danger">{{ $errors->first('password') }}</p>
                    @endif
                </div>
                <div class="field">
                    <label class="checkbox">
                        <input type="checkbox">&nbsp;&nbsp;Remember me
                    </label>
                </div>
                <button type="submit" class="button is-block is-primary">
                    <i class="fa fa-btn fa-sign-in"> Login
                </button>
            </form>
        </div>
        <p class="has-text-grey">
            <a href="{{ url('/password/reset') }}">Forgot Password</a>
        </p>
    </div>
</div>
@endsection
