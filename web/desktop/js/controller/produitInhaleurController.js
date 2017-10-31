app.controller('produitInhaleurCtrl',['$scope','$rootScope','$location','planService',function($scope,$rootScope,$location, planService){

	//for show loading
	$rootScope.loading=true;
	$scope.page="produit-nicorette-inhaleur";
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