
var littleUrl = angular.module('littleUrl', ['angular-clipboard', 'angular-ladda']);

littleUrl.controller('HomeController',
    ['$scope', 'UrlService', 'clipboard', function($scope, UrlService, clipboard) {
        $scope.errorOccured = false;
        $scope.urlCreated = false;

        $scope.createUrl = function() {
            $scope.loading = true;
            UrlService.create($scope.url).then(showSuccessMessage, showErrorMessage);
        };

        $scope.copyUrl = function() {
            clipboard.copyText($scope.url);
            swal({
                title: 'Success',
                text: 'Url Copied to Clipboard',
                type: 'success',
                showConfirmButton: false,
                timer: 1000
            })
        };

        $scope.removeErrorMessage  = function() {
            $scope.errorOccured = false;
        }

        function showSuccessMessage(response) {
            $scope.currentUrl = response.data.url.link;
            $scope.urlCreated = true;
            $scope.loading = false;
            $scope.errorOccured = false;
        }

        function showErrorMessage(response) {
            $scope.urlCreated = false;
            $scope.errorOccured = true;
            $scope.errorMessage = response.data.url[0];
            $scope.loading = false;
        }
}]);

littleUrl.factory('UrlService', function($http) {
    return {
        create: function(url) {
            return $http.post('url/create', { url: url });
        }
    }
});
//
// var UrlForm = {
//     init: function() {
//         this.bindEvents();
//     },
//     bindEvents: function() {
//         $(document).on('click', '#submit-form', this.submitForm);
//
//         var clipboard = new Clipboard('#copy-url', {
//             text: function (trigger) {
//                 return $(trigger).data('link');
//             }
//         });
//
//         clipboard.on('success', function(e) {
//             e.clearSelection();
//             $('#copy-url').notify('Success!', {
//                 className: 'success',
//                 position: 'right',
//                 autoHideDelay: 2000,
//                 arrowShow: false,
//                 gap: 10
//             });
//         });
//     },
//     submitForm: function(e) {
//         e.preventDefault();
//
//         var self = UrlForm;
//         self.hideError();
//         var l = Ladda.create(document.querySelector('#submit-form'));
// 	        l.start();
//
//         var data = $('#url-form').serialize();
//         $.post('url/create', data)
//             .success(function(response) {
//                 self.renderResponse('#response-message-template', '#response-message', response.url);
//             }, 'json')
//             .error(function(response) {
//                 self.showError(response.responseJSON.url[0]);
//             })
//             .always(function() {
//                  l.stop();
//             });
//
//         return false;
//     },
//     renderResponse: function(templateSelector, messageSelector, data) {
//         var template = $(templateSelector).html();
//         var html = Mustache.render(template, data);
//         $(messageSelector).html(html);
//     },
//     showError: function(message) {
//         var $formButton = $('#submit-form');
//         $formButton.closest('.form-group').addClass('has-error');
//         $formButton.addClass('btn-danger');
//         $('#url-error-message').text(message);
//     },
//     hideError: function() {
//         var $formButton = $('#submit-form');
//         $formButton.closest('.form-group').removeClass('has-error');
//         $formButton.removeClass('btn-danger');
//         $('#url-error-message').text('');
//     }
// };
//
// $(function() {
//     UrlForm.init();
// });
