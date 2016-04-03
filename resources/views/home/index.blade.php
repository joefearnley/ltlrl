@extends('layout')

@section('content')
    <div class="content">
        <div class="container content-page">
            <div class="row margin-bottom">
                <div class="col-md-8 col-md-offset-2">
                    <h4>What are you looking to do?</h4>
                </div>
            </div>
            <div class="row margin-bottom">
                <div class="col-md-8 col-md-offset-2">
                    <a href="/account/edit" class="btn btn-info margin-right"><i class="fa fa-edit"></i> Edit Account</a>
                    <a href="/account/property/register" class="btn btn-info margin-right"><i class="fa fa-clipboard"></i> Register Property</a>
                    <a href="/account/properties" class="btn btn-info margin-right"><i class="fa fa-list"></i> View Properties</a>
                </div>
            </div>
        </div>
    </div>
@endsection