@extends('layouts.app')

@section('content')
    <div id="app" class="container-fluid">
        <div class="row">
            @include('account.nav')
            <div class="col-sm-9 col-md-10">
                <h2>Account Overview</h2>
                <div class="row">
                    <div class="col-md-3">
                        <div class="tile tile-dark-blue">
                            <div class="img">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <div class="content">
                                <p class="big counter">{{ $accountTotals->getDaysMakingUrlsLittle() }}</p>
                                <p class="title">Days Making Urls Little</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="tile tile-dark-blue">
                            <div class="img">
                                <i class="fa fa-link"></i>
                            </div>
                            <div class="content">
                                <p class="big counter">{{ $accountTotals->getUrlsMade() }}</p>
                                <p class="title">Urls Made Little</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="tile tile-dark-blue">
                            <div class="img">
                                <i class="fa fa-mouse-pointer"></i>
                            </div>
                            <div class="content">
                                <p class="big counter">{{ $accountTotals->getUrlsClickedOn() }}</p>
                                <p class="title">Urls Clicked On</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="/js/account/overview.js"></script>
@endsection
