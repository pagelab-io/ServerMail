(function(){

    'use strict';

    var app = angular.module('todoApp', [], function() { });

    app.controller('todoController', function($scope, $http) {

        // Current comment.
        this.todo = {};
        this.todos = [];
        this.loading = true;

        this.init = function() {
            this.loading = true;

            var self = this;

            $http.get('/api/todos').success(function(data, status, headers, config) {
                self.todos = data;
                self.loading = false;

                //console.log(data);
            });
        };

        this.addTodo = function() {
            this.loading = true;
            var self = this;
            //var token = $('meta[name="csrf_token"]').attr('content');

            $http.post('/api/todos/store', {
                title: this.todo.title,
                done: this.todo.done
            }).success(function(data, status, headers, config) {
                self.todos.push(data);
                self.todo = '';
                self.loading = false;

            }).error(function(r){
                $('body').html(r);
            });
        };

        this.updateTodo = function(todo) {
            this.loading = true;

            var self = this;

            $http.put('/api/todos/' + todo.id + '/update', {
                done: todo.done
            }).success(function(data, status, headers, config) {
                self.todo = data;
                self.loading = false;
            });
        };

        this.deleteTodo = function(index) {
            this.loading = true;
            var todo = this.todos[index];
            var self = this;

            /* Call servvar self = this;er api */
            $http.delete('/api/todos/' + todo.id + '/delete')
                .success(function() {
                    self.todos.splice(index, 1);
                    self.loading = false;
                });
        };


        this.init();
    });
}());