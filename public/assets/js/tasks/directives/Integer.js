(function() {
    'use strict';

    // Convert to integer
    angular
        .module('Integer', [])
        .directive('Integer', function () {
            return {
                require: 'ngModel',
                link: function(scope, ele, attr, ctrl){
                    ctrl.$parsers.unshift(function(viewValue){
                        return parseInt(viewValue, 10);
                    });
                }
            };
            }
        );
})();
