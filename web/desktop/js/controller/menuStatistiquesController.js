app.controller( 'menuStatistiquesCtrl', ['headerService','$scope','$rootScope','$location','authService','$http','$q','$window','appSettings', function(headerService,$scope,$rootScope,$location,authService,$http,$q,$window,appSettings){

	//for show loading
	//$rootScope.loading=true;
	$scope.page="menu-statistiques";
	$scope.userName=authService.user.data.givenName;
	$scope.infos = [];
	$scope.infosHeader = [];
	
	angular.element(document).ready(function () {
		$('#cssmenu > ul > li:has(ul)').addClass("has-sub");
		 
		 $('#cssmenu > ul > li > p').click(function() {
			 var checkElement = $(this).next();
		    
		    $('#cssmenu li').removeClass('active');
		    $(this).closest('li').addClass('active');	
		    
		    
		    if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
		      $(this).closest('li').removeClass('active');
		      checkElement.slideUp('normal');
		    }
		    
		    if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
		      $('#cssmenu ul ul:visible').slideUp('normal');
		      checkElement.slideDown('normal');
		    }
		    
		    if (checkElement.is('ul')) {
		      return false;
		    } else {
		      return true;	
		    }		
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
		  if($scope.infos.length==0){
				$scope.getInfoStatistics()
				.then(function(res){
				    	          //console.log(res);
				            	  $scope.infos = res;
				            	  $rootScope.loading=false;
				      },function(res){
				    	         $scope.infos=[];
				            	 alert("Une erreur s'est produite lors de connexion au web service!")
				      }
			     );		 
	      }
    });
	
	$scope.getInfoStatistics=function(){
		var deferred = $q.defer();
	     
	     var token=$window.localStorage.getItem('janrainCaptureToken');
		 $http.get(appSettings.baseUrl+'/statistic?token='+token+'')
			  .success(function(res){
				 //console.log(res);
				 deferred.resolve(res.data);
			  })
			  .error(function(res){
				 deferred.reject(res);
			  });		 
		 return deferred.promise;
	}
	
}])









