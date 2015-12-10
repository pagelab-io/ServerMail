(function(){
    'use strict';

// Main start point
    angular
        .module('taskApp', [
            'EnterStroke',
            'TaskService',
            'TaskController',
            'Integer'
        ]);


// TaskResource Test
    angular
        .module('TaskResource', []);

})();