@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="columns">
            @include('account.nav')
            <div class="column m-t-md">
                <h1 class="title">Account Settings</h1>
                <update-personal-information-form></update-personal-information-form>
                <update-password-form></update-password-form>
            </div>
        </div>
    </div>
</div>
@endsection
