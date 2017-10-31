app.controller('arreterFelicitationCtrl', ['$scope', '$rootScope', '$location', 'authService', '$http', '$q', 'appSettings', '$window', function($scope, $rootScope, $location, authService, $http, $q, appSettings, $window) {        

	//for show loading
	//$rootScope.loading=true;
	$scope.page="arreter-felicitation";
        $scope.userName=authService.user.data.givenName;
        
        
	/*
         * Author Hassine Lataoui : jethass@hotmail.com
         * redirect to dashboard
         */
        $scope.redirectToDashbord = function() {
            $location.path('/dashboard');
        }
}])