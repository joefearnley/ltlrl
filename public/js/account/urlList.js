var UrlList = {
    init: function() {
        this.bindEvents();
        this.loadUrlList();
    },
    bindEvents: function() {
        $(document).on('click', '.edit-url', this.showEditModal);
        $(document).on('click', '.save-url', this.saveUrl);
        $(document).on('click', '.confirm-delete-url', $.proxy(this.showDeleteConfirmation, this));
        // $(document).on('click', '.delete-url', this.deleteUrl);

        $('#edit-modal').on('hidden.bs.modal', function() {
            $(this).html('');
        });

        // $('#delete-modal').on('hidden.bs.modal', function() { $(this).html(''); });

        new Clipboard('.copy-url', {
            text: function (trigger) {
                return $(trigger).data('url');
            }
        }).on('success', function(e) {
            e.clearSelection();
            swal({
                showConfirmButton: false,
                title: 'Success!',
                text: 'Url Copied.',
                type: 'success',
                timer: 1000
            });
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
        var self = this;

        var uri = '/url/' + $(this).data('id');

        swal({
            title: 'Are you sure?',
            text: 'Are you sure you want to delete this Little Url?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            preConfirm: $.proxy(this.deleteUrl, this, uri)
        }).then(function() {
            swal({
                title: 'Success!',
                text: 'Url Deleted.',
                type: 'success',
                timer: 2000
            });

            self.loadUrlList();
        });

        // $.get(uri).success(function(response) {
        //     var template = $('#delete-modal-template').html();
        //     var html = Mustache.render(template, response);
        //     $('#delete-modal').html(html).modal('show');
        // });
    },
    deleteUrl: function(uri) {
        $.post(uri)
            .done(function(response) {
                setTimeout(function() {
                    resolve();
                }, 1000)
            })
            .fail(function(jqXHR) {
                reject(jqXHR.responseJSON.url[0]);
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
        urls.forEach(function(url) {
            var selector = '.click-chart-' + url.id;
            var labels = [];
            var data = [];

            $.get('/url/stats/' + url.id).done(function(response) {
                response.forEach(function(click) {
                    labels.push(click.date);
                    data.push(click.clicks);
                });

                self.createChart(selector, labels, data);
            });
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
                            beginAtZero: true,
                            callback: function(value) {if (value % 1 === 0) {return value;}}
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
