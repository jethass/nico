app.factory('httpInterceptorService', ['$q', '$injector','$location', '$window',  function ($q, $injector, $location, $window) {

    return {

    // optional method
    'request': function(config) {
        config.headers = config.headers || {};      
       
        var token = $window.localStorage.getItem('janrainCaptureToken');
        if (token) {
            config.headers.Authorization = 'Bearer ' + token;
        }
        return config;
    },

    'response': function(response) {
    	
         // successful response
        return response; // or $q.when(config);
    },
    'requestError': function(rejection) {
    	
        // an error happened on the request
        // if we can recover from the error
        // we can return a new request
        // or promise
        //return response; // or new promise
        // Otherwise, we can reject the next
        // by returning a rejection  	
        return $q.reject(rejection);
    },
    'responseError': function(rejection) {
    	if(rejection.status == '401'){
    		//console.log($injector.authService)
    		$injector.get('authService').logout();
    		$location.path('/login');
    	}
        // an error happened on the request
        // if we can recover from the error
        // we can return a new response
        // or promise
        //return rejection; // or new promise
       // Otherwise, we can reject the next
       // by returning a rejection
        return $q.reject(rejection);
    }

  };

}]);