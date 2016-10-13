var accountSettings = angular.module('acccount', ['angular-ladda']);

accountSettings.controller('AccountSettingsController', function($scope, AccountService) {

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
                showMessage('Error!', 'Error Updating Personal Info.', 'error');
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
                showMessage('Error!', 'Error Updating Password.', 'error');
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

accountSettings.factory('AccountService', function($http) {
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
            var data = {
                password: password,
                confirmPassword: confirmPassword
            };
            return $http.post('/api/account/update-password', data);
        }
    };
});

// var PersonalForm = {
//     init: function() {
//         this.bindEvents();
//     },
//     bindEvents: function() {
//         var self = PersonalForm;
//         $('#personal-info-form').validator().on('submit', function (e) {
//             if (!e.isDefaultPrevented()) {
//                 self.savePersonalInfo(e);
//             }
//         });
//     },
//     savePersonalInfo: function(e) {
//         e.preventDefault();
//         var l = Ladda.create(document.querySelector('#update-personal-info'));
//         l.start();
//         var data = $('#personal-info-form').serialize();
//         $.post('/api/account/update-personal-info', data)
//             .success(function(response) {
//                 swal({
//                     title: 'Success!',
//                     text: 'User Updated.',
//                     type: 'success',
//                     timer: 2000
//                 });
//             })
//             .always(function() {
//                 l.stop();
//             });
//     }
// };
//
// var UpdatePasswordForm = {
//     init: function() {
//         this.bindEvents();
//     },
//     bindEvents: function() {
//         var self = UpdatePasswordForm;
//         $('#update-password-form').validator().on('submit', function (e) {
//             if (!e.isDefaultPrevented()) {
//                 self.updatePassword(e);
//             }
//         });
//     },
//     updatePassword: function(e) {
//         e.preventDefault();
//         var self = UpdatePasswordForm;
//         var l = Ladda.create(document.querySelector('#update-password-button'));
//         l.start();
//         var data = $('#update-password-form').serialize();
//
//         $.post('/api/account/update-password', data)
//             .success(function(response) {
//                 swal({
//                     title: 'Success!',
//                     text: 'Password Updated.',
//                     type: 'success',
//                     timer: 2000
//                 });
//             })
//             .error(function(response) {
//                 self.showError(response);
//             })
//             .always(function() {
//                 l.stop();
//             });
//     },
//     showError: function(response) {
//         var message = '<div>';
//         $.each(response.responseJSON.password, function(i, errorMessage) {
//             message += '<p class="text-danger">' + errorMessage + '</p>';
//         });
//         message += '</div>';
//         swal({
//             title: 'Error Updating Password.',
//             text: message,
//             type: 'warning'
//         });
//     }
// };
//
// $(function() {
//     PersonalForm.init();
//     UpdatePasswordForm.init();
// });
