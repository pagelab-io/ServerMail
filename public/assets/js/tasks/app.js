(function(){
    'use strict';

    angular
        .module('taskApp', ['taskServices'])
        .controller('TaskController', TaskController);

    TaskController.$inject = ['$scope', '$http', 'Task'];

    function TaskController($scope, $http, Task) {

        // ViewModel
        var vm = this;

        // Define a new entity.
        vm.task = {};

        // List of todos
        vm.tasks = [];

        // Flag that indicates if it loading
        vm.loading = false;

        vm.init = function() {
            vm.loading = true;

            Task.index().success(function(data) {

                if (data) {
                    vm.tasks = data;
                    vm.loading = false;
                }
            });

        };

        vm.addTask = function() {
            vm.loading = true;

            var newTask = {
                name: vm.task.name,
                done: vm.task.done
            };

            console.log(newTask);

            Task.store(newTask).success(function(data) {

                console.log(data);

                if (data) {
                    vm.tasks.unshift(data);
                    vm.task = '';
                    vm.loading = false;
                }

            }).error(function(r){

            });
        };

        vm.updateTask = function(task) {
            vm.loading = true;

            console.log(task);

            Task.update(task.id, {
                name: task.name
            }).success(function(data) {

                if (data) {
                    vm.task = data;
                    vm.loading = false;
                }
            });
        };

        vm.toggleDone = function(task){
            vm.loading = true;

            Task.toggleDone(task.id, {
                done: task.done
            }).success(function(data) {

                if (data) {
                    vm.task = data;
                    vm.loading = false;
                }
            });

        },

        vm.deleteTask = function(index) {
            vm.loading = true;
            var task = vm.tasks[index];

            Task.destroy(task.id)
                .success(function(response) {

                    if (response) {
                        vm.tasks.splice(index, 1);
                        vm.loading = false;
                    }
                });
        };


        vm.init();
    }

}());