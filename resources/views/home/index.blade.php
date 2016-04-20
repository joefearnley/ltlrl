@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="container content-page">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-md-8 col-md-offset-2 align-center">
                    <h1>Little URL</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="url/create" method="post">
                                {!! csrf_field() !!}
                                <div class="input-group input-group-lg">
                                    <input type="text" name="url" id="url" class="form-control input-lg" placeholder="Enter URL">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-default">Make it Little</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('newUrl'))
            <div class="row result">
                <div class="col-md-8 col-md-offset-2">
                    <h4>URL has been made little! - <strong>{{ session('newUrl') }}</strong></h4>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection