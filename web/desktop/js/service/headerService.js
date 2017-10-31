app.factory('headerService', ['$http', 'appSettings', '$q', '$window', function($http, appSettings, $q, $window){

	var initHeader = function(){
		var deferred = $q.defer();
        var token = $window.localStorage.getItem('janrainCaptureToken');
        /*
         * Author Amir DIMASSI : amir.el-dimassi@proxym-it.com
         * function de récupération de nombre d jour sans tabac
         */
        $http.get(appSettings.baseUrl + '/withoutcigarette/' + token + '')
                .success(function(res) {
                    if (res.success == 1) {
                        deferred.resolve(res.data);
                    } else {
                    	deferred.resolve(res.data);
                    }
                })
                .error(function(res) {
                    deferred.reject(res);
                });
        return deferred.promise;
	}
	
	var hasDoctor = function(){
		var deferred = $q.defer();
        var token = $window.localStorage.getItem('janrainCaptureToken');
        
        $http.get(appSettings.baseUrl + '/has_doctor?token=' + token)
                .success(function(res) {
                	deferred.resolve(res);
                })
                .error(function(res) {
                    deferred.reject(res);
                });
        return deferred.promise;
	}
	
	return { 
		initHeader: initHeader,
		hasDoctor: hasDoctor
	}
}])
