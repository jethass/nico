app.factory('quizService', ['$http', 'appSettings', '$q', '$window', function($http, appSettings, $q, $window){

	var quiz = {			
			step: 'FEEDBACk_1',
						
	}
	
	
	var getQuiz = function(step){
		
		var deferred = $q.defer(),
		token;
		
		token = $window.localStorage.getItem('janrainCaptureToken');
		
		$http.get(appSettings.baseUrl+"/quiz/"+step,
		{ params: { token: token }		
		})
		 
		 .success(function(res){
			 deferred.resolve(res.data);
		 })
		 
		 .error(function(res){
			 deferred.reject(res);
		 })
		
		
		 return deferred.promise;
		
	}
	
	
	  var submitQuiz = function(step, data){
		
		 var deferred = $q.defer(),
		      data = data || {};
		 
         data.token = $window.localStorage.getItem('janrainCaptureToken');
         data.code = step;
         				 
		 $http.post(appSettings.baseUrl+'/answers/'+step, data)
		 .success(function(res){
			 deferred.resolve(res)
		 })
		 
		 .error(function(res){
			 deferred.reject(res)
		 });			 			 
		 
		 return deferred.promise;
			  			  
	}
	  
	  var saveQuiz = function(){
			
			 var deferred = $q.defer(),
			      data = data || {};
			 
	         data.token = $window.localStorage.getItem('janrainCaptureToken');
	         				 
			 $http.post(appSettings.baseUrl+'/initquiz/answers/save', data)
			 .success(function(res){
				 deferred.resolve(res)
			 })
			 
			 .error(function(res){
				 deferred.reject(res)
			 });			 			 
			 
			 return deferred.promise;
				  			  
	}
	
	
	return {
		quiz: quiz,
		submitQuiz: submitQuiz,
		getQuiz: getQuiz,
		saveQuiz: saveQuiz,
	}
	
	
	
	
}])
