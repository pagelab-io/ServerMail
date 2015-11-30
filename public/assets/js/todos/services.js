(function(){
    "use strict";

    angular
        .module('taskServices', [])
        .factory('Task', Task);

    Task.$inject = ['$http'];

    function Task($http){

        var Task = {

            /**
             * Url base of the API
             */
            url: '/api/tasks/',

            /**
             * Call server method for retrieve all tasks of current
             * user authenticated
             *
             * @returns Promise
             */
            index: function(){
                return $http.get(Task.url);
            },

            /**
             * Call server method for create a new task
             *
             * @param task
             * @returns Promise
             */
            store: function(task){
                return $http.post(Task.url + 'store', task);
            },

            /**
             * Call server method for update the specified task
             *
             * @param id
             * @param data
             * @returns Promise
             */
            update: function(id, data){
                return $http.put(Task.url  + id + '/update', data);
            },

            /**
             * Call server method for delete the specified task
             * from the storage
             *
             * @param id
             * @returns Promise
             */
            destroy: function(id){
                return $http.delete(Task.url + id + '/delete');
            }

        };

        return Task;
    }

})();