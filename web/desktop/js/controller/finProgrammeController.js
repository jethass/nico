app.controller('finProgrammeCtrl',['$scope','$rootScope','$location',function($scope,$rootScope,$location){

	//for show loading
	//$rootScope.loading=true;
	$scope.page="fin-programme";
	
	angular.element(document).ready(function () {
	
			    
			    $("#contenu-slider").slider({
			        range: "min",
			        value: 0,
			        min: 0,
			        max: 100,
			        step: 5,
			    });
               
               $("#programme-slider").slider({
			        range: "min",
			        value: 0,
			        min: 0,
			        max: 100,
			        step: 5,
			    });
               
               $("#frequence-slider").slider({
			        range: "min",
			        value: 0,
			        min: 0,
			        max: 100,
			        step: 5,
			    });
			    
			     $("#personalisation-slider").slider({
			        range: "min",
			        value: 0,
			        min: 0,
			        max: 100,
			        step: 5,
			    });
			    
		
    });	
 	
}])








