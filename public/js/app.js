$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var CreateUrlForm = {
    init: function() {
        this.bindEvents();
    },
    bindEvents: function() {
        var self = this;
        $(document).on('click', '#show-add-url-form', $.proxy(this.showModal, this));
    },
    showModal: function() {
        swal({
            title: 'Make Url Little',
            input: 'text',
            showCancelButton: true,
            confirmButtonText: 'Make Little',
            showLoaderOnConfirm: true,
            preConfirm: $.proxy(this.saveUrl, this),
            allowOutsideClick: false
        }).then(this.showSuccessMessage);
    },
    saveUrl: function(url) {
        var self = this;
        return new Promise(function(resolve, reject) {
            var data = {
                url: url
            };

            $.post('/url/create', data)
                .done(function(response) {
                    setTimeout(function() {
                        self.refreshPage();
                        resolve();
                    }, 1000)
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    reject(jqXHR.responseJSON.url[0]);
                });
        });
    },
    showSuccessMessage: function() {
        swal({
            title: 'Success!',
            text: 'Url Made Little.',
            type: 'success',
            timer: 2000
        });
    },
    refreshPage: function() {
        if (typeof UrlList != 'undefined') {
            UrlList.loadUrlList();
        } else if (window.location.pathname === '/account') {
            window.location.reload();
        }
    }
};

$(function() {
    CreateUrlForm.init();
});


'use strict';

var app = angular.module('Ltltr', []);
var home = angular.module('home', ['angular-clipboard', 'angular-ladda']);

home.controller('HomeController', ['$scope', 'UrlService', 'clipboard',
    function($scope, UrlService, clipboard) {
        $scope.errorOccured = false;
        $scope.urlCreated = false;

        $scope.copyUrl = function() {
            clipboard.copyText($scope.url);
            swal({
                title: 'Success',
                text: 'Url Copied to Clipboard',
                type: 'success',
                showConfirmButton: false,
                timer: 1000
            });
        };

        $scope.removeErrorMessage  = function() {
            $scope.errorOccured = false;
        };

        $scope.createUrl = function() {
            $scope.loading = true;
            UrlService.create($scope.url).then(showSuccessMessage, showErrorMessage);
        };

        var showSuccessMessage = function(response) {
            $scope.currentUrl = response.data.url.link;
            $scope.urlCreated = true;
            $scope.loading = false;
            $scope.errorOccured = false;
        };

        var showErrorMessage = function(response) {
            $scope.urlCreated = false;
            $scope.errorOccured = true;
            $scope.errorMessage = response.data.url[0];
            $scope.loading = false;
        };
}]);

home.factory('UrlService', function($http) {
    return {
        create: function(url) {
            return $http.post('url/create', { url: url });
        }
    }
});

//# sourceMappingURL=app.js.map
