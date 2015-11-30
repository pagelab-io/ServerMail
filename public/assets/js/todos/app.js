(function(){
    'use strict';

    angular
        .module('todoApp', ['taskServices'])
        .controller('todoController', TodoController);

    TodoController.$inject = ['$scope', '$http', 'Task'];

    function TodoController($scope, $http, Task) {

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

            Task.index().success(function(data) {
                vm.todos = data;
                vm.loading = false;
            });

        };

        vm.addTodo = function() {
            vm.loading = true;

            var newTask = {
                name: vm.todo.name,
                done: vm.todo.done
            };

            Task.store(newTask).success(function(data) {
                vm.todos.unshift(data);
                vm.todo = '';
                vm.loading = false;

                console.log(data);

            }).error(function(r){

            });
        };

        vm.updateTodo = function(task) {
            vm.loading = true;

            Task.update(task.id, {
                done: task.done
            }).success(function(data) {
                vm.todo = data;
                vm.loading = false;

                console.log(data);
            });
        };

        vm.deleteTodo = function(index) {
            vm.loading = true;
            var todo = vm.todos[index];

            Task.destroy(todo.id)
                .success(function(response) {
                    vm.todos.splice(index, 1);
                    vm.loading = false;
                });
        };


        vm.init();
    }


}());