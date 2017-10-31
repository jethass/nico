app.controller('mecanismePointsCtrl', ['headerService','$scope','$rootScope','$location','authService','$http','$q','$window','appSettings', function(headerService,$scope,$rootScope,$location,authService,$http,$q,$window,appSettings){

	//for show loading
	//$rootScope.loading=true;
	$scope.page="mecanisme-points";
	$scope.userName=authService.user.data.givenName;
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
		
	});
}])








