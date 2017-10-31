app.factory('planService', ['$http', 'appSettings', '$q', '$window', function($http, appSettings, $q, $window){

	
	var getPlan = function(){
		
		var deferred = $q.defer(),
		token;
		
		token = $window.localStorage.getItem('janrainCaptureToken');
		
		$http.get(appSettings.baseUrl+"/plan",
		{ params: { token: token }		
		})
		 
		 .success(function(res){
			 deferred.resolve(res);
		 })
		 
		 .error(function(res){
			 deferred.reject(res);
		 })
		
		
		 return deferred.promise;
		
	}
	
	postPlan = function(answers, code){
		var deferred = $q.defer(),
	      data = data || {};
	 
	   data.token = $window.localStorage.getItem('janrainCaptureToken');
	   data.answers = answers;
	   
	   $http.post(appSettings.baseUrl+'/plan/answers/save/'+code, data)
		 .success(function(res){
			 deferred.resolve(res)
		 })
		 
		 .error(function(res){
			 deferred.reject(res)
		 });			 			 
		 
		 return deferred.promise;
	}
	
	contractFix = function(){
		var deferred = $q.defer(),
		token;
	 
	   token = $window.localStorage.getItem('janrainCaptureToken');
	   
	   $http.get(appSettings.baseUrl+'/contract/info/date?token='+token)
		.success(function(res){
			 deferred.resolve(res);
		 })
		 
		 .error(function(res){
			 deferred.reject(res);
		 })
		
		
		 return deferred.promise;
	}
	
	planAccess = function(){
		var deferred = $q.defer(),
		token;
	 
	   token = $window.localStorage.getItem('janrainCaptureToken');
	   
	   $http.get(appSettings.baseUrl+'/plan/access?token='+token)
		.success(function(res){
			 deferred.resolve(res);
		 })
		 
		 .error(function(res){
			 deferred.reject(res);
		 })
		
		
		 return deferred.promise;
	}
	
	
	
	
	
	return {
		getPlan: getPlan,
		postPlan: postPlan,
		contractFix: contractFix,
		planAccess: planAccess,
	}
	
}])
