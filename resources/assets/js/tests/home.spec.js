describe('Home Test', function() {

    beforeEach(angular.mock.module('home'));

    describe('Home Controller', function() {
        var controller;
        var scope;

        beforeEach(angular.mock.inject(function(_$controller_, _$rootScope_) {
            scope = _$rootScope_.$new();
            controller = _$controller_('HomeController', { $scope: scope });
        }));

        it('should load controller and scope', function() {
            expect(controller).toBeDefined();
            expect(scope).toBeDefined();
        });
    })

});
