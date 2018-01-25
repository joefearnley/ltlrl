@extends('layouts.app')

@section('content')

<div class="container">
    <div class="column is-4 is-offset-4">
        <h4 class="title is-4 has-text-centered">Sign Up</h4>
        <div class="box">
            <form method="POST" action="{{ url('/register') }}">
                {!! csrf_field() !!}
                <div class="field">
                    <label class="label">Name</label>
                    <div class="control">
                        <input class="input {{ $errors->has('name') ? 'is-danger' : '' }}" type="text" name="name" value="{{ old('name') }}" autofocus="">
                    </div>
                    @if ($errors->has('name'))
                        <p class="help is-danger">{{ $errors->first('name') }}</p>
                    @endif
                </div>
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
                        <input class="input {{ $errors->has('password') ? 'is-danger' : '' }}" type="password" name="password" value="{{ old('password') }}">
                    </div>
                    @if ($errors->has('password'))
                        <p class="help is-danger">{{ $errors->first('password') }}</p>
                    @endif
                </div>
                <div class="field">
                    <label class="label">Confirm Password</label>
                    <div class="control">
                        <input class="input {{ $errors->has('password_confirmation') ? 'is-danger' : '' }}" type="password" name="password_confirmation" value="{{ old('password_confirmation') }}">
                    </div>
                    @if ($errors->has('password_confirmation'))
                        <p class="help is-danger">{{ $errors->first('password_confirmation') }}</p>
                    @endif
                </div>
                <button type="submit" class="button is-block is-primary">
                    <i class="fa fa-btn fa-user"> Sign Up
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
