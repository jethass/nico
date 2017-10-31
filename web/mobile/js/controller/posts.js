app.controller('PostCtrl',function($scope,QuizFactory,$rootScope){
    $rootScope.loading=true;
    QuizFactory.find().then(
       function(quizes){
           $rootScope.loading=false;
           $scope.quizes=quizes;
       },function(msg){
          alert(msg);
       }
    );
    
   /* $scope.addArticle=function(article){
        //console.log(article);
    	QuizFactory.addArticle(article).then(
            function(data){
               $scope.redirect('#/');
            },function(msg){
               alert(msg);
            }
       );
    };*/
    
    
    
});  