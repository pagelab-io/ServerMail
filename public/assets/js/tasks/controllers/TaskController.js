(function(){
    'use strict';

    angular
        .module('TaskController', [])
        .controller('TaskController', TaskController);

    TaskController.$inject = ['Task'];

    function TaskController(Task) {

        // ViewModel
        var vm = this;

        // Define a new entity.
        vm.task = {};

        // List of todos
        vm.tasks = [];

        vm.errors = [];

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
            // Init vars
            vm.loading = true;
            vm.errors = [];

            var newTask = {
                name: vm.task.name,
                done: vm.task.done
            };

            Task.store(newTask).success(function(response) {

                if (response.success == 1 && response.data) {
                    vm.tasks.unshift(response.data);
                    vm.task = '';
                    vm.loading = false;
                } else {

                    for(var error in response.message) {
                        if (response.message[error]) {
                            vm.errors.push(response.message[error][0]);
                        }
                    }
                }

            }).error(function(r){

            });
        };

        vm.updateTask = function(task) {
            vm.loading = true;

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

            console.log(task);

            Task.toggleDone(task.id, {
                done: task.done
            }).success(function(response) {

                console.log(response);

                if (response.success == 1) {
                    vm.task = response.data;
                    vm.loading = false;
                }
            });

        };

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