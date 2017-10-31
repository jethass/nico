app.controller('boutonPaniqueCtrl',['$scope','$rootScope','$location','authService','extraPointService',function($scope,$rootScope,$location,authService,extraPointService){

	//for show loading
	//$rootScope.loading=true;
	$scope.page="bouton-panique";
	$scope.userName=authService.user.data.givenName;

    // author abdeljabbar saiid
    $scope.addTrickPoint=function(type){
        extraPointService.postPointTrick(type)
            .then(function(res){console.log(type);
                switch (type){
                    case 'actuality_site_consultation':{window.open('http://news.google.fr/','_blank');break;}
                    default :{$location.path('/dashboard');}
                }

                //$rootScope.loading = false;
            },function(res){
                alert("Une erreur s'est produite lors de connexion au web service!")
            }
        );
    }
}])