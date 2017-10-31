app.controller('forgetPasswordCtrl', ['$scope','$rootScope','$location','$interval','authService','$http','$q','appSettings','$timeout','forgotPasswordService', function($scope,$rootScope, $location,$interval,authService,$http,$q,appSettings,$timeout,forgotPasswordService){
    
	 $scope.person={};
	 $scope.mailSucess=false;	
	 $scope.mailError=false;
	 $scope.blocksuccess = false;
	 $scope.page="forget-password";
	 
	 $scope.getAuthorizationCode= function (){
		 var renewalLink="";
		 
		 forgotPasswordService.getUuid($scope.person.email)
		 .then(function(data){
			 if(data.success){
				$scope.blocksuccess = true;
			 }else{
				 $scope.mailError=true;
			 }
		 });
	 }
	 
}])
