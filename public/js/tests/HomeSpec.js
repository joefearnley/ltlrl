describe('home page test', function () {

    beforeEach(angular.mock.module('home'));

    var $controller;

    beforeEach(angular.mock.inject(function(_controller_){
        $controller = _controller_;
    }));

    // url is empty
    it ('should show an error when nothing is entered', function() {
    });

    // url is invalid
    it ('should show an error when an invalid url is entered', function() {
    });


    it('1 + 1 should equal 2', function () {
        var $scope = {};
        var controller = $controller('CalculatorController', { $scope: $scope });
        $scope.x = 1;
        $scope.y = 2;
        $scope.sum();
        expect($scope.z).toBe(3);
    });
});



    it ('should create a little url', function() {
    });
});
