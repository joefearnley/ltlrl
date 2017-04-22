var account = angular.module('acccount', ['angular-ladda']);

account.controller('AccountSettingsController', function($scope, AccountService) {

    AccountService.getAccountInfo().then(function(response) {
        $scope.name = response.data.name;
        $scope.email = response.data.email;
    });

    $scope.updatePersonalInfo = function() {
        $scope.updatingInfo = true;
        AccountService.updatePersonalInfo($scope.name, $scope.email)
            .then(function(response) {
                $scope.updatingInfo = false;
                showMessage('Success!', 'Person Info Updated.', 'success');
            }, function(error) {
                $scope.updatingInfo = false;
            });
    };

    $scope.updatePassword = function() {
        $scope.updatingPassword = true;
        AccountService.updatePassword($scope.password, $scope.confirmPassword)
            .then(function(response) {
                $scope.updatingPassword = false;
                $scope.reset();
                showMessage('Success!', 'Password Updated.', 'success');
            }, function(error) {
                $scope.updatingPassword = false;
            });
    };

    $scope.reset = function() {
        $scope.password = '';
        $scope.confirmPassword = '';
    };

    function showMessage(title, text, type) {
        swal({
            title: title,
            text: text,
            type: type,
            timer: 1000,
            showConfirmButton: false
        });
    }

    $scope.updatingInfo = false;
    $scope.updatingPassword = false;
    $scope.reset();
});

account.factory('AccountService', function($http) {
    return {
        getAccountInfo: function() {
            return $http.get('/api/account/info');
        },
        updatePersonalInfo: function(name, email) {
            var data = JSON.stringify({
                name: name,
                email: email
            });

            return $http.post('/api/account/update-personal-info', data);
        },
        updatePassword: function(password, confirmPassword) {
            var data = JSON.stringify({
                password: password,
                password_confirmation: confirmPassword
            });

            return $http.post('/api/account/update-password', data);
        }
    };
});
