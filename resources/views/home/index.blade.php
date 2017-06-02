@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="container home-page">
            <div class="columns">
                <div class="column is-8 is-offset-2">
                    <form id="url-form" class="form-horizontal">
                        <div class="field has-addons">
                            <p class="control is-expanded"><input class="input" id="url" type="text" placeholder="Enter Url and ..."></p>
                            <p class="control"><a class="button is-primary">Make it Little</a></p>
                        </div>
                    </form>
                    <div class="results"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
