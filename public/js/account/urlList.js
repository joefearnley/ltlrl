var UrlList = {
    init: function() {
        this.bindEvents();
        this.loadUrlList();
    },
    bindEvents: function() {
        $(document).on('click', '.edit-url', this.showEditModal);
        $(document).on('click', '.save-url', this.saveUrl);
        $(document).on('click', '.confirm-delete-url', this.showDeleteConfirmation);
        $(document).on('click', '.delete-url', this.deleteUrl);

        $('#edit-modal').on('hidden.bs.modal', function() {
            $(this).html('');
        });

        $('#delete-modal').on('hidden.bs.modal', function() {
            $(this).html('');
        });
    },
    loadUrlList: function() {
        var self = UrlList;
        $.get('/api/account/urls')
            .done(function(response) {
                var template = $('#url-list-template').html();
                var html = Mustache.render(template, response);
                $('#url-list').html(html);
                self.createCharts(response.urls);
            });
    },
    showEditModal: function() {
        var uri = '/url/' + $(this).data('id');
        $.get(uri).done(function(response) {
            var template = $('#edit-modal-template').html();
            var html = Mustache.render(template, response);
            $('#edit-modal').html(html).modal('show');
        });
    },
    saveUrl: function() {
        var self = UrlList;
        var l = Ladda.create(document.querySelector('.ladda-button'));
        l.start();
        var data = $('#edit-url-form').serialize();
        $.post('/url/update', data)
            .done(function(response) {
                swal({
                    title: 'Success!',
                    text: 'Url Saved.',
                    type: 'success',
                    timer: 2000
                });
                $('#edit-modal').html('').modal('hide');
                self.loadUrlList();
            })
            .error(function(response) {
                self.showError(response.responseJSON.url[0]);
            })
            .always(function() {
                l.stop();
            });
    },
    showDeleteConfirmation: function() {
        var uri = '/url/' + $(this).data('id');
        $.get(uri).success(function(response) {
            var template = $('#delete-modal-template').html();
            var html = Mustache.render(template, response);
            $('#delete-modal').html(html).modal('show');
        });
    },
    deleteUrl: function() {
        var self = UrlList;
        var uri = '/url/delete/' + $(this).data('id');
        $.post(uri).done(function() {
            swal({
                title: 'Success!',
                text: 'Url Deleted.',
                type: 'success',
                timer: 2000
            });
            $('#delete-modal').html('').modal('hide');
            self.loadUrlList();
        });
    },
    showError: function(message) {
        $('.form-group').addClass('has-error');
        $('#url-error-message').text(message);
    },
    hideError: function() {
        $('.form-group').removeClass('has-error');
        $('#url-error-message').text('');
    },
    createCharts: function(urls) {
        var self = UrlList;

        var urlsGroupedByDate = [];
        urls.forEach(function(url) {
            
        });

        urls.forEach(function(url) {
            var selector = '.click-chart-' + url.id;
            var labels = [];
            var data = [];

            url.clicks.forEach(function(click) {
                labels.push(click.formatted_date);
                data.push(click.id);
            });

            self.createChart(selector, labels, data);
        });
    },
    createChart: function(selector, labels, data) {
        new Chart($(selector), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: '# of Clicks',
                    data: data,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    }
};

$(function() {
    UrlList.init();
});
