app.controller('infosLegaleCtrl',['headerService','$scope','$rootScope','$location','$routeParams','authService','$window',function(headerService,$scope,$rootScope,$location,$routeParams,authService,$window){

	//for show loading
	//$rootScope.loading=true;
	var token=$window.localStorage.getItem('janrainCaptureToken');
	$scope.page="infos-legales";
	
	$scope.bloc=$routeParams.bloc;
	
	
	
	// test if connect
	$scope.connect="";
	
	if(token != null){
	  $scope.connect = 1;
	  $scope.userName=authService.user.data.givenName;
    }else{
   	  $scope.connect = 0;
   	  $scope.userName="";
   	}
	$scope.infosHeader = [];
   	
	angular.element(document).ready(function () {
		$("html, body").animate({ scrollTop: 0 }, "slow");

		$( "#confidentialite" ).click(function() {
			if($( "#confidentialite" ).hasClass( "confidentialite" ))
				   $("#confidentialite").removeClass('confidentialite');
			else
				$("#confidentialite").addClass('confidentialite');
		});

		$( "#CGU" ).click(function() {
			if($( "#CGU" ).hasClass( "CGU" ))
				$("#CGU").removeClass('CGU');
			else
				$("#CGU").addClass('CGU');
		});

		$( "#cookies" ).click(function() {
			if($( "#cookies" ).hasClass( "cookies" ))
				$("#cookies").removeClass('cookies');
			else
				$("#cookies").addClass('cookies');
		});



		 $('#cssmenu > ul > li > p').click(function() {
	      
			var checkElement = $(this).next();
		    
            if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
		      $(this).closest('li').removeClass('active');
		      checkElement.slideUp('normal');
		     
		    }
		    
		    if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
		      $('#cssmenu ul ul:visible').slideUp('normal');
		      checkElement.slideDown('normal');

		    }

		  });
		
		  if($scope.infosHeader.length==0 && token != null){
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








