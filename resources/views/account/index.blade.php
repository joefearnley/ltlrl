@extends('layouts.app')

@section('content')
    <div id="app" class="container-fluid">
        <div class="row">
            @include('account.nav')
            <div class="col-sm-9 col-md-10">
                <h2>Account Overview</h2>
            </div>
        </div>
    </div>
@endsection
