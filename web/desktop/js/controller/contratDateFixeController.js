app.controller('contratDateFixeCtrl',['headerService','$scope', '$location', 'planService', '$rootScope','authService',function(headerService,$scope, $location, planService, $rootScope, authService){

	//for show loading
	$rootScope.loading=true;
	$scope.page="contrat-date-fixe";
	$scope.userName = authService.user.data.givenName;
	$scope.infosHeader = [];
	
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
	planService.planAccess()
	 .then(function(res){
		 if(res.success == true && res.data.date){
			 $rootScope.loading=false;
			 $scope.date = res.data.date;
		 }else if(res.data.contraturl){
			 $rootScope.loading=false;
			 $location.path('/'+res.data.contraturl);
		 } 
	 })
	 
}])