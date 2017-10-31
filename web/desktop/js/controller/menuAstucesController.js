app.controller( 'menuAstucesCtrl', ['extraPointService','$scope','$rootScope','$location', 'authService', 'headerService',function(extraPointService,$scope,$rootScope,$location, authService, headerService){

	//for show loading
	//$rootScope.loading=true;
	$scope.page="menu-astuces";
	$scope.userName = authService.user.data.givenName;
	$scope.infosHeader = [];
	
	if($scope.infosHeader.length==0){
   		headerService.initHeader()
   		.then(function(res){
   		            	  $scope.infosHeader = res;
   		      },function(res){
   		    	         $scope.infosHeader = [];
   		            	 alert("Une erreur s'est produite lors de connexion au web service!")
   		      }
   	     );		 
   	}
    // author abdeljabbar saiid
    $scope.addTrickPoint=function(type){
        extraPointService.postPointTrick(type)
            .then(function(res){console.log(type);
                switch (type){
                    case 'trick_1':{window.open('https://www.nicorette.fr/je-songe-a-m-arreter-de-fumer/retrouver-les-benefices-de-l-arret-jour-apres-jour','_blank');break;}
                    case 'trick_2':{window.open('https://www.nicorette.fr/je-me-lance/les-strategies-d-arret','_blank');break;}
                    case 'trick_3':{window.open('https://www.nicorette.fr/je-garde-le-cap/des-astuces-pour-aider-a-tenir/gerer-son-environnement','_blank');break;}
                    case 'trick_4':{window.open('https://www.nicorette.fr/je-garde-le-cap/des-astuces-pour-aider-a-tenir/gerer-les-tentations','_blank');break;}
                    case 'trick_5':{window.open('https://www.nicorette.fr/je-garde-le-cap/gerer-une-envie-de-cigarette','_blank');break;}
                    case 'trick_6':{window.open('https://www.nicorette.fr/je-me-lance/ma-vie-pendant-le-sevrage/comprendre-le-sevrage-tabagique','_blank');break;}
                    case 'trick_7':{window.open('https://www.nicorette.fr/comprendre-le-tabagisme/idees-recues/les-substituts-nicotiniques','_blank');break;}
                    case 'trick_8':{window.open('https://www.nicorette.fr/je-garde-le-cap/gerer-la-rechute/n-abandonnez-pas-la-partie','_blank');break;}
                    case 'trick_9':{window.open('https://www.nicorette.fr/je-garde-le-cap/gerer-la-rechute/comprendre-la-rechute','_blank');break;}
                    default :{$location.path('/dashboard');}
                }

                //$rootScope.loading = false;
            },function(res){
                alert("Une erreur s'est produite lors de connexion au web service!")
            }
        );
    }

}])









