
var LittleUrl = angular.module('LittleUrl', ['angular-clipboard']);

LittleUrl.controller('HomeController',
    ['$scope', 'UrlService', 'clipboard', function($scope, UrlService, clipboard) {
        $scope.createUrl = function() {
            UrlService.create($scope.url)
                .then(function successCallback(response) {
                    console.log(response);

                    var template = $('#response-message-template').html();
                    var html = Mustache.render(template, response.url);
                    $('#response-message').html(html);
                }, function errorCallback(response) {
                    var $formButton = angular.element('#submit-form');
                    $formButton.addClass('btn-danger').closest('.form-group').addClass('has-error');
                    angular.element('#url-error-message').text(response.data.url[0]);
                });
        };

        $scope.copy = function() {
            clipboard.copyText($scope.url);
            swal({
                title: 'Success',
                text: 'Url Copied to Clipboard',
                timer: 1000
            })
        };
}]);

LittleUrl.factory('UrlService', function($http) {
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
