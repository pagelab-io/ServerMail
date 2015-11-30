(function(){
    'use strict';

    angular
        .module('todoApp', [])
        .controller('todoController', TodoController);

    TodoController.$inject = ['$scope', '$http'];

    function TodoController($scope, $http) {

        // ViewModel
        var vm = this;

        // Current entity.
        vm.todo = {};

        // List of todos
        vm.todos = [];

        // Flag that indicates if it loading
        vm.loading = true;

        vm.init = function() {
            vm.loading = true;

            $http.get('/api/tasks').success(function(data, status, headers, config) {
                vm.todos = data;
                vm.loading = false;
            });
        };

        vm.addTodo = function() {
            vm.loading = true;

            $http.post('/api/tasks/store', {
                name: vm.todo.name,
                done: vm.todo.done
            }).success(function(data, status, headers, config) {
                vm.todos.push(data);
                vm.todo = '';
                vm.loading = false;

                console.log(data);

            }).error(function(r){

            });
        };

        vm.updateTodo = function(todo) {
            vm.loading = true;

            $http.put('/api/tasks/' + todo.id + '/update', {
                done: todo.done
            }).success(function(data, status, headers, config) {
                vm.todo = data;
                vm.loading = false;

                console.log(data);
            });
        };

        vm.deleteTodo = function(index) {
            vm.loading = true;
            var todo = vm.todos[index];

            /* Call server */
            $http.delete('/api/tasks/' + todo.id + '/delete')
                .success(function(response) {
                    vm.todos.splice(index, 1);
                    vm.loading = false;
                });
        };


        vm.init();
    }


}());