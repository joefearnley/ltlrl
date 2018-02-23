@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="columns">
            @include('account.nav')
            <urls-list></urls-list>
        </div>
    </div>
@endsection
