app.factory('extraPointService', ['$http', 'appSettings', '$q', '$window', function($http, appSettings, $q, $window){

	postPointTrick = function(type){
		var deferred = $q.defer(),
	      data = data || {};

	   data.token = $window.localStorage.getItem('janrainCaptureToken');
	   data.type = type;

	   $http.post(appSettings.baseUrl+'/patient/add-extra-point', data)
		 .success(function(res){
			 deferred.resolve(res)
		 })
		 
		 .error(function(res){
			 deferred.reject(res)
		 });			 			 
		 
		 return deferred.promise;
	}
	
	return {
        postPointTrick: postPointTrick
	}
	
}])
