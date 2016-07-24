$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});

var createUrlForm = {
    init: function() {
        this.bindEvents();
    },
    bindEvents: function() {
        $(document).on('click', '#show-add-url-form', this.showModal);

        $('#add-url-modal').on('hidden.bs.modal', function() {
            $('#enter-url').val('');
        });
    },
    showModal: function() {
        $('#add-url-modal').modal('show');
    },
    saveUrl: function(e) {
        e.preventDefault();

        
    }
};

$(function() {
    createUrlForm.init();
});
