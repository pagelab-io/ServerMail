(function(){
    "use strict";

    angular
        .module('taskDirectives', [])
        .directive('contenteditable', ContentEditable);


    function ContentEditable(){

        var ContentEditable = {
            restrict: "A",
            require: 'ngModel',
            link: function(scope, element, attrs, ctrl){

                function read() {
                    ctrl.$setViewValue(element.html());
                }

                // model - view
                ctrl.$render = function() {
                    element.html(ctrl.$viewValue);
                };

                // view -> model
                element.bind("blur", function(){
                    scope.$apply(read);
                });
            }
        };

        return ContentEditable;
    }

})();