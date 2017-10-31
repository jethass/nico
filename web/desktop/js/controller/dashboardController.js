app.controller('dashboardCtrl',['$scope','$rootScope','$location','authService','$http','$q','$window','appSettings', 'planService',function($scope,$rootScope,$location,authService,$http,$q,$window,appSettings, planService){
	
	var connexion = localStorage.getItem('connexion');
	
	//alert(localStorage.getItem('janrainCaptureToken'));
	if( localStorage.getItem('janrainCaptureToken') == null ){
		authService.logout();
		//$location.path('/login');
		$window.location.href = '/';
	}
	
	planService.planAccess()
	.then(function(res){
    	if(res.success == false && res.errors.length == 0){
    		console.log(res.data);
    		if(res.data.feedbackUrl){
    			$location.path('/'+res.data.feedbackUrl);
    		}else if(res.data.fixlater == 1){
	    		if(res.data.contraturl && !connexion){
    				$rootScope.contratUrl = res.data.contraturl;
    				localStorage.setItem('connexion', true);
    				if($rootScope.device == "desktop"){
    					$("#modalPlan2").trigger("click");
    				}else{
    					$("#modalPlan2Mobile").trigger("click");
    				}
	    		}
    		}
    	}
	}
	);
	
	//for show loading
	$rootScope.loading=true;
	$scope.page="dashboard";
	$scope.userName=authService.user.data.givenName;
	$scope.infos=[];
	$scope.infosHeader=[];
	angular.element(document).ready(function () {
		
			if($scope.infos.length==0){
					$scope.getInfoDashboard()
					.then(
					      function(res){
					    	          //console.log(res);
					            	  $scope.infos=res;
					            	  $scope.infosHeader=res;
					            	  $rootScope.loading=false;
					      },
				          function(res){
					    	         $scope.infos=[];
					    	         $scope.infosHeader=[];
					            	 alert("Une erreur s'est produite lors de connexion au web service!")
					      }
				     );		 
		    }
			$scope.showPopUp = function(nbPopUp, actived){
				if( actived == true){
					$("#modalBadge"+nbPopUp).modal();
				}
			};
	});
	
	$scope.togglePanique=function(){
		
               $('.slideTogglebox').slideToggle();
            
	};
	
	
	$scope.getInfoDashboard=function(){
			var deferred = $q.defer();
		     
		     var token=$window.localStorage.getItem('janrainCaptureToken');
			 $http.get(appSettings.baseUrl+'/dashboard?token='+token+'')
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








