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
        var self = CreateUrlForm;
        $(document).on('click', '#show-add-url-form', this.showModal);
        //$(document).on('click', '#submit-make-url-little-button', $.proxy(this.saveUrl, this));

        $('#add-url-form').validator().on('submit', function (e) {
            e.preventDefault();
            console.log('alsfkjlkasjflksf');
            if (!e.isDefaultPrevented()) {
                self.saveUrl(e);
            }
        });

        $('#add-url-modal').on('hidden.bs.modal', function() {
            $('#enter-url').val('');
        });
    },
    showModal: function() {
        $('#add-url-modal').modal('show');
    },
    saveUrl: function(e) {
        e.preventDefault();
        var l = Ladda.create(document.querySelector('.ladda-button'));
        l.start();
        var data = $('#add-url-form').serialize();
        $.post('/url/create', data)
            .success(function(response) {
                swal({
                    title: 'Success!',
                    text: 'Url Made Little.',
                    type: 'success',
                    timer: 2000
                });
            })
            .always(function() {
                l.stop();
            });
    }
};

$(function() {
    CreateUrlForm.init();
});
