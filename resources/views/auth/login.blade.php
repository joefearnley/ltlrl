@extends('layouts.app')

@section('content')
<div class="container has-text-centered">
    <div class="column is-4 is-offset-4">
        <div class="box">
            <form method="POST" action="{{ url('/login') }}">
                {!! csrf_field() !!}
                <div class="field">
                    <div class="control">
                        <input class="input {{ $errors->has('email') ? 'is-danger' : '' }}" type="email" name="email" placeholder="Your Email"  value="{{ old('email') }}" autofocus="">
                    </div>
                    @if ($errors->has('email'))
                        <p class="help is-danger has-text-left">{{ $errors->first('email') }}</p>
                    @endif
                </div>
                <div class="field">
                    <div class="control">
                        <input class="input {{ $errors->has('password') ? 'is-danger' : '' }}" type="password" name="password" placeholder="Your Password">
                    </div>
                    @if ($errors->has('password'))
                        <p class="help is-danger has-text-left">{{ $errors->first('password') }}</p>
                    @endif
                </div>
                <div class="field">
                    <label class="checkbox">
                        <input type="checkbox">&nbsp;&nbsp;Remember me
                    </label>
                </div>
                <button type="submit" class="button is-block is-primary login">Login</button>
            </form>
        </div>
        <p class="has-text-grey">
            <a href="../">Sign Up</a> &nbsp;·&nbsp;
            <a href="{{ url('/password/reset') }}">Forgot Password</a>
        </p>
    </div>
</div>
@endsection
