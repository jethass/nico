app.controller('mesAlertesCtrl',['headerService','$scope','$rootScope','$location','authService',function(headerService,$scope,$rootScope,$location,authService){

	//for show loading
	//$rootScope.loading=true;
	$scope.page="mes-alertes";
	$scope.userName=authService.user.data.givenName;
	$scope.optins = [{"id":1,"name":"Oui"},{"id":2,"name":"Non"}];
	$scope.brand = false;
	$scope.johnson = false;
	$scope.other = false;
	$scope.infosHeader = [];
	
	$scope.setBrandOptin = function(id){
		if(id == 1){$scope.brand=true;}else{$scope.brand=false;}
	}
	
	$scope.isBrandChecked = function(id){
		if($scope.brand){
			if(id == 1 && $scope.brand == true){
				return true
			}
		}else if(id == 2 && $scope.brand == false){
			return true;
		}else{
			return false;
		}
	}
	
	$scope.setJohnsonOptin = function(id){
		if(id == 1){$scope.johnson=true;}else{$scope.johnson=false;}
	}
	
	$scope.isJohnsonChecked = function(id){
		if($scope.johnson){
			if(id == 1 && $scope.johnson == true){
				return true
			}
		}else if(id == 2 && $scope.johnson == false){
			return true;
		}else{
			return false;
		}
	}
	
	$scope.setOtherOptin = function(id){
		if(id == 1){$scope.other=true;}else{$scope.other=false;}
	}
	
	$scope.isOtherChecked = function(id){
		if($scope.other){
			if(id == 1 && $scope.other == true){
				return true
			}
		}else if(id == 2 && $scope.other == false){
			return true;
		}else{
			return false;
		}
	}
	
	authService.getProfile() 
    .then(
        function(res){
        	if(res.success == true){
        		$scope.profile=res.data.profile;
        		$scope.brand = $scope.profile.BrandOpt;
        		$scope.johnson = $scope.profile.JJSBF;
        		$scope.other = $scope.profile.OtherMember;
        		$scope.amount = $scope.profile.amount;
        	    $scope.packet = $scope.profile.packet;
        	}
        },
        function(){
        	$scope.profile={};
        }
    );
	
	$scope.submitAlerts = function(){
		authService.updateProfile($scope.amount, $scope.packet, $scope.brand, $scope.johnson, $scope.other) 
	    .then(
	        function(res){
	        	if(res.success == true){
	        		console.log(res.data.msg);
	        	}
	        }
	    );
	}
	
	angular.element(document).ready(function () {
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