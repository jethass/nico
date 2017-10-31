var app = angular.module('MonApp', ['ngRoute','ngResource']);
app.config(function ($routeProvider) {
                $routeProvider
		.when('/', {templateUrl: '/mobile/partials/home.html',controller:'PostCtrl'})
		.when('/comments/:id', {templateUrl: '/mobile/partials/comments.html', controller: 'CommentsCtrl'})
		.otherwise({redirectTo: '/'});
});
/*app.controller('PostCtrl',function($scope,$resource){
    //var Post=$resource('/posts/:id.json');
    //var Post=$resource('http://symfony-angular.dev/app_dev.php/articles');
    //$scope.posts=Post.query();
    //$scope.post=Post.get({id:1});
});*/