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

            Task.index()
            Task.index().success(function(response) {
                console.log('--Tasks--');
                console.log(response);
                if (response) {
                    vm.tasks = response.data;
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

                if (response.success == 0 && response.data) {
                    console.log('[message: ' + response.message + ']');
                    vm.tasks.unshift(response.data);
                    vm.task = '';
                    vm.loading = false;
                } else {

                    if (response.message() instanceof Array) {
                        for (var error in response.message) {
                            if (response.message[error]) {
                                vm.errors.push(response.message[error][0]);
                            }
                        }
                    } else {
                        console.log('[message: ' + response.message + ']');
                    }
                }

            }).error(function(r){
                console.log(r);
            });
        };

        vm.updateTask = function(task) {
            vm.loading = true;

            Task.update(task.id, {
                name: task.name
            }).success(function(response) {
                console.log('[message: ' + response.message + ']');
                if (response.success == 0) {
                    vm.loading = false;
                }
            });
        };

        vm.toggleDone = function(task){
            vm.loading = true;

            Task.toggleDone(task.id, {
                done: task.done
            }).success(function(response) {
                console.log('[message: ' + response.message + '  done: '+ response.data.done + ']');
                if (response.success == 0) {
                    vm.loading = false;
                }
            });

        };

        vm.deleteTask = function(index) {
            vm.loading = true;
            var task = vm.tasks[index];

            Task.destroy(task.id)
                .success(function(response) {
                    console.log('[message: ' + response.message + ']');
                    if (response.success == 0) {
                        vm.tasks.splice(index, 1);
                        vm.loading = false;
                    }
                });
        };

        vm.init();
    }

}());