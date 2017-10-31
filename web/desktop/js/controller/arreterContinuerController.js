app.controller('arreterContinuerCtrl', ['$scope', '$rootScope', '$location', 'authService', '$http', '$q', 'appSettings', '$window', function($scope, $rootScope, $location, authService, $http, $q, appSettings, $window) {        

	//for show loading
	//$rootScope.loading=true;
	$scope.page="arreter-continuer";
        $scope.userName=authService.user.data.givenName;
         	
	
}])