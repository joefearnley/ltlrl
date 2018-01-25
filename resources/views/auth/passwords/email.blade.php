@extends('layouts.app')

@section('content')
<div class="container">
    <div class="column is-4 is-offset-4">
        <h3 class="title is-4 has-text-centered">Reset Password</h3>
        <div class="box">
            <form method="POST" action="{{ url('/password/email') }}">
                {!! csrf_field() !!}
                <div class="field">
                    <label class="label">Email Address</label>
                    <div class="control">
                        <input class="input {{ $errors->has('email') ? 'is-danger' : '' }}" type="email" name="email" value="{{ old('email') }}" autofocus="">
                    </div>
                    @if ($errors->has('email'))
                        <p class="help is-danger">{{ $errors->first('email') }}</p>
                    @endif
                </div>
                <button type="submit" class="button is-block is-primary">
                    <i class="fas fa-btn fa-envelope"></i> Send Password Reset Link
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
