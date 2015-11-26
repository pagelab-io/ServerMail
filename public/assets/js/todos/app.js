'use strict';

var app = angular.module('todoApp', [], function() { });

app.controller('todoController', function($scope, $http) {

    $scope.comments = [];
    $scope.loading = true;

    $scope.init = function() {
        $scope.loading = true;

        setTimeout(function(){
            $http.get('/api/todos').success(function(data, status, headers, config) {
                $scope.comments = data;
                $scope.loading = false;
            });
        }, 0);
    };

    $scope.addTodo = function() {
        $scope.loading = true;
        //var token = $('meta[name="csrf_token"]').attr('content');

        $http.post('/api/todos/store', {
            title: $scope.todo.title,
            done: $scope.todo.done
        }).success(function(data, status, headers, config) {
            $scope.comments.push(data);
            $scope.todo = '';
            $scope.loading = false;

        }).error(function(r){
            $('body').html(r);
        });
    };

    $scope.updateTodo = function(todo) {
        $scope.loading = true;

        $http.put('/api/todos/' + todo.id + '/update', {
            done: todo.done
        }).success(function(data, status, headers, config) {
            todo = data;
            $scope.loading = false;

        });
    };

    $scope.deleteTodo = function(index) {
        $scope.loading = true;
        var todo = $scope.comments[index];

        /* Call server api */
        $http.delete('/api/todos/' + todo.id + '/delete')
            .success(function() {
                $scope.comments.splice(index, 1);
                $scope.loading = false;

            });
    };


    $scope.init();
});