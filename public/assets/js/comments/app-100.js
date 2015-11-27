(function(){

    'use strict';

    // App
    var commentsApp = angular.module('commentsApp', []);

    // Controller
    commentsApp.controller('CommentsController', ['$scope', '$http',  function($scope, $http){

        // Current comment.
        this.comment = {};

        // Array where comments will be.
        this.comments = [];

        // Load init comments
        this.init = function() {
            this.loading = true;

            var self = this;

            $http.get('/api/comments').success(function(data, status, headers, config) {

                self.comments = data;
                self.loading = false;
            });
        };

        // Fires when form is submitted.
        this.addComment = function() {
            this.loading = true;
            var self = this;
            //var token = $('meta[name="csrf_token"]').attr('content');
            $http.post('/api/comments/store', {
                text: this.comment.text
            }).success(function(data, status, headers, config) {
                self.comments.push(data);
                self.comment = '';
                self.loading = false;

                // Reset classes of the form after submit.
                $scope.form.$setPristine();

            }).error(function(r){$('body').html(r);});
        };

        this.init();
    }]);

})();
