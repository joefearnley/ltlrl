var UrlForm = {
    init: function() {
        this.bindEvents();
    },
    bindEvents: function() {
        $(document).on('click', '#submit-form', this.submitForm);

        var clipboard = new Clipboard('#copy-url', {
            text: function (trigger) {
                return $(trigger).data('link');
            }
        });

        clipboard.on('success', function(e) {
            e.clearSelection();
            $('#copy-url').notify('Success!', {
                className: 'success',
                position: 'right',
                autoHideDelay: 2000,
                arrowShow: false,
                gap: 10
            });
        });
    },
    submitForm: function(e) {
        e.preventDefault();

        var self = UrlForm;
        self.hideError();
        var l = Ladda.create(document.querySelector('#submit-form'));
	        l.start();

        var data = $('#url-form').serialize();
        $.post('url/create', data)
            .success(function(response) {
                self.renderResponse('#response-message-template', '#response-message', response.url);
            }, 'json')
            .error(function(response) {
                self.showError(response.responseJSON.url[0]);
            })
            .always(function() {
                 l.stop();
            });

        return false;
    },
    renderResponse: function(templateSelector, messageSelector, data) {
        var template = $(templateSelector).html();
        var html = Mustache.render(template, data);
        $(messageSelector).html(html);
    },
    showError: function(message) {
        var $formButton = $('#submit-form');
        $formButton.closest('.form-group').addClass('has-error');
        $formButton.addClass('btn-danger');
        $('#url-error-message').text(message);
    },
    hideError: function() {
        var $formButton = $('#submit-form');
        $formButton.closest('.form-group').removeClass('has-error');
        $formButton.removeClass('btn-danger');
        $('#url-error-message').text('');
    }
};

$(function() {
    UrlForm.init();
});
