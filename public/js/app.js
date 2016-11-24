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

(function() {
    'use strict';

    var app = angular.module('Ltltr', []);
    var home = angular.module('home', ['angular-clipboard', 'angular-ladda']);
})();

//# sourceMappingURL=app.js.map
