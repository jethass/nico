app.controller('produitComprimeeCtrl',['planService','$scope','$rootScope','$location',function(planService,$scope,$rootScope,$location){

	//for show loading
	//$rootScope.loading=true;
	$scope.page="produit-nicorette-comprimee";
	$scope.fager = 0;
	planService.getPlan()
	 .then(function(res){
		 if(res.success == true){
			 if(res.data){
				 $scope.fager = res.data.scoreFager;
				 $rootScope.loading = false;
			 }else{
				 $location.path('/dashboard');
			 }
		 }else{
			 $location.path('/dashboard');
		 }
	 });
}])