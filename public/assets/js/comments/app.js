var commentApp = angular.module('commentApp', [], function() { });

commentApp.controller('commentController', function($scope, $http) {

    $scope.comments = [];
    $scope.loading = true;

    $scope.init = function() {
        $scope.loading = true;

        setTimeout(function(){
            $http.get('/api/comments').success(function(data, status, headers, config) {
                $scope.comments = data;
                $scope.loading = false;

                console.log(data);
            });

        }, 0);
    };

    $scope.addComment = function() {
        $scope.loading = true;
        //var token = $('meta[name="csrf_token"]').attr('content');
        $http.post('/api/comments/store', {
            text: $scope.comment.text
        }).success(function(data, status, headers, config) {
            $scope.comments.push(data);
            $scope.comment = '';
            $scope.loading = false;

        }).error(function(r){
            $('body').html(r);
        });
    };

    $scope.init();
});