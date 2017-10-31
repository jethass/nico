app.controller('produitsNicoretteCtrl',['headerService','$scope','$rootScope','$location','authService',function(headerService,$scope,$rootScope,$location, authService){

	//for show loading
	//$rootScope.loading=true;
	$scope.page="produits-nicorette";
	$scope.userName=authService.user.data.givenName;
	$scope.infosHeader = [];
	$scope.doctor = false;
	
	headerService.hasDoctor()
		.then(function(res){
			if(res.data && res.data.isKnownByDoctor){
				$scope.doctor = res.data.isKnownByDoctor;
			}
		 });
	
	angular.element(document).ready(function () {
		$(".tabs-menu a").click(function(event) {
	        event.preventDefault();
	        $(this).parent().addClass("current");
	        $(this).parent().siblings().removeClass("current");
	        var tab = $(this).attr("href");
	        $(".tab-content").not(tab).css("display", "none");
	        $(tab).fadeIn();
        });
		
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








