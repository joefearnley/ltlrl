
var urlList = angular.module('urlList', ['angular-clipboard', 'angular-ladda']);

urlList.controller('UrlListController',
    ['$scope', 'UrlListService', 'clipboard', function($scope, UrlListService, clipboard) {
        $scope.noUrlsFound = false;

        $scope.loadList = function() {
            UrlListService.getList().then(function(response) {
                $scope.urls = response.data.urls;
                $scope.noUrlsFound = response.data.urls.length == 0;
            });
        };

        $scope.copyUrl = function(url) {
            clipboard.copyText(url);
            swal({
                title: 'Success',
                text: 'Url Copied to Clipboard',
                type: 'success',
                showConfirmButton: false,
                timer: 1000
            });
        };

        $scope.editUrl = function(id) {
        };

        $scope.deleteUrl = function(id) {

            swal({
                title: 'Are you sure?',
                text: 'Are you sure you want to delete this Little Url?',
                type: 'warning',
                showCancelButton: true,
                showLoaderOnConfirm: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                preConfirm: function() {
                    return new Promise(function(resolve, reject) {
                        $.post('/url/delete/' + id)
                            .done(function(response) {
                                setTimeout(function() {
                                    resolve();
                                }, 1000);
                            })
                            .fail(function(jqXHR) {
                                reject(jqXHR.responseJSON.url[0]);
                            });
                    });
                }
            }).then(function() {
                swal({
                    title: 'Success!',
                    text: 'Url Deleted.',
                    type: 'success',
                    showConfirmButton: false,
                    timer: 1000
                });

                $scope.loadList();
            });

            // UrlListService.delete(id);
        };

        function createCharts() {
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

                    createChart(selector, labels, data);
                });
            });
        }

        function createChart(selector, labels, data) {
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

        $scope.loadList();
}]);

urlList.factory('UrlListService', function($http) {
    return {
        getList: function() {
            return $http.get('/api/account/urls');
        },
        delete: function(id) {

        },
        createCharts: function() {

        }
    };
});
