const CreateUrlForm = {
    init: function() {
        this.bindEvents();
    },
    bindEvents: function() {
        document.querySelector('#show-add-url-form')
            .addEventListener('click', this.showModal.bind(this)); // this??
    },
    showModal: function() {
        swal({
            title: 'Make Url Little',
            input: 'text',
            showCancelButton: true,
            confirmButtonText: 'Make Little',
            showLoaderOnConfirm: true,
            preConfirm: this.saveUrl.bind(this),
            allowOutsideClick: false
        }).then(this.showSuccessMessage);
    },
    saveUrl: function(url) {
        const self = this;
        return new Promise((resolve, reject) => {
            $.post('/url/create', { url: url })
                .done(function(response) {
                    setTimeout(function() {
                        self.refreshPage();
                        resolve();
                    }, 1000);
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
        }
    }
};

(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    CreateUrlForm.init();
})();
