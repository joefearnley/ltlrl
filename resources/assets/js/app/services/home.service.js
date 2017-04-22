home.factory('UrlService', function($http) {
    return {
        create: function(url) {
            return $http.post('url/create', { url: url });
        }
    }
});
