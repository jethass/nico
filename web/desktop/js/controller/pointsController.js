app.controller('pointsCtrl', ['headerService','$scope','$rootScope','$location','authService','$http','$q','$window','appSettings', function(headerService,$scope,$rootScope,$location,authService,$http,$q,$window,appSettings){

	//for show loading
	$rootScope.loading=true;
	$scope.page="mes-points";
	$scope.userName=authService.user.data.givenName;
	$scope.infos = [];
    var date= new Date();
    $scope.dateNow = moment(date).format("DD/MM/YYYY");
    $scope.infosHeader = [];
    	
    	
	angular.element(document).ready(function () {
		if($scope.infosHeader.length==0){
       		headerService.initHeader()
       		.then(function(res){
       		    	          //console.log(res);
       		            	  $scope.infosHeader = res;
       		            	  //$rootScope.loading = false;
       		      },function(res){
       		    	         $scope.infosHeader = [];
       		            	 alert("Une erreur s'est produite lors de connexion au web service!")
       		      }
       	     );		 
       	}
		if($scope.infos.length==0){
				$scope.getInfoMyPoints()
				.then(function(res){
				    	          console.log(res);
				            	  $scope.details = res.details.reverse();
                                                  $scope.points = res.points;
				            	  $rootScope.loading=false;
				      },function(res){
				    	         $scope.infos=[];
				            	 alert("Une erreur s'est produite lors de connexion au web service!")
				      }
			     );		 
	      }
		  
    });
	
	$scope.getInfoMyPoints=function(){
		var deferred = $q.defer();
	     
	     var token=$window.localStorage.getItem('janrainCaptureToken');
		 $http.get(appSettings.baseUrl+'/mypoints/'+token+'')
			  .success(function(res){
				 deferred.resolve(res);
			  })
			  .error(function(res){
				 deferred.reject(res);
			  });		 
		 return deferred.promise;
	}
}])








