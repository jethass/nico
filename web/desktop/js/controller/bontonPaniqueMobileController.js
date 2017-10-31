app.controller('boutonPaniqueMobileCtrl',['$scope','$rootScope','$location','authService',function($scope,$rootScope,$location,authService){

	//for show loading
	//$rootScope.loading=true;
	$scope.page="bouton-panique-mobile";
	$scope.userName=authService.user.data.givenName;
	
}])