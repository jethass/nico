app.controller('CommentsCtrl',function($scope,QuizFactory,$routeParams,$rootScope){
    $rootScope.loading=true;
    $scope.newComment={};
    
    QuizFactory.get($routeParams.id).then(
            function(post){
                $rootScope.loading=false;
                $scope.title=post.name;
                $scope.picture = post.picture;
		$scope.content = post.content;
                $scope.comments=post.comments;
            },function(msg){
                alert(msg);
            }
     );
     
     $scope.addComment=function(){
         $scope.comments.push($scope.newComment);
         QuizFactory.add($scope.newComment).then(
           function(){
               
           },function(){
               alert("votre message n'a pas pu étre sauvgardé ");
           }
          );
         $scope.newComment={};
     };
     
     
    
});  