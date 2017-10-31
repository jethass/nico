app.factory('forgotPasswordService', ['$http', 'appSettings', '$q', '$window', function($http, appSettings, $q, $window){

	/* get uuid by mail */
	var getUuid = function(email){
		
		var deferred = $q.defer();
		
		$http.get(appSettings.baseUrl+"/user/forgot/authCode?email="+email)
		 .success(function(res){
			 deferred.resolve(res);
		 })
		 
		 .error(function(res){
			 deferred.reject(res);
		 });
		
		return deferred.promise;
		
	}
	
	return {
		getUuid: getUuid,
	}
	
	
	
	
}])
