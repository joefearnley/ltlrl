@extends('layout')

@section('content')
    <div class="content">
        <div class="container content-page">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 align-center">
                    <h1>Little URL</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="{{ url('url/save') }}">
                                <div class="input-group input-group-lg">
                                    <input type="text" name="url" id="url" class="form-control input-lg" placeholder="Enter URL">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-default">Make Little</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection