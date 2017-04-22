
angular.module('home', ['angular-clipboard', 'angular-ladda'])
.controller('HomeController', ['$scope', 'UrlService', 'clipboard',
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
}])
.factory('UrlService', function($http) {
    return {
        create: function(url) {
            return $http.post('url/create', { url: url });
        }
    }
});
