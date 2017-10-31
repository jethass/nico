'use strict';
app.factory('authService', ['$window', '$location', '$http', '$q', 'appSettings', function ($window, $location, $http, $q, appSettings) {
   
  var setLoggedIn = function(){
	 user.isAuth = checkUserIsAuth();
	 user.data = JSON.parse($window.localStorage.getItem('janrainCaptureProfileData')) || null;
	 
   }
  
  var checkUserIsAuth = function(){
	 var expireDate = new Date($window.localStorage.getItem('janrainCaptureProfileData_Expires')).getTime();
	 var now = new Date().getTime();
	 
	 if((expireDate)&&(expireDate < now)){
		 return false;
	 }
	 
	 if(!$window.localStorage.getItem('janrainCaptureToken')){
		 return false;
	 }
	 
	 return true;
	 
  }
  
  var user = {
	   	  isAuth: checkUserIsAuth(),
	   	  data: JSON.parse($window.localStorage.getItem('janrainCaptureProfileData')) || null
	   };
  
  var getNextStep = function(){
	 
	 var deferred = $q.defer();
	  
	 if((user.data)&&(user.data.uuid)){
		 $http.get(appSettings.baseUrl+'/user/auth?uuid='+user.data.uuid+'&token='+ $window.localStorage.getItem('janrainCaptureToken') +'&expires='+ $window.localStorage.getItem('janrainCaptureProfileData_Expires'))
		 .success(function(res){
			 deferred.resolve(res);
		 })
		 
		 .error(function(res){
			 deferred.reject(res);
		 });
		 
		 
	 }else{
		 deferred.reject();
	 }
	 
	 return deferred.promise;
	  
	  
  }
  
  
/* get Profile from janrain*/
	var getProfile = function(){
		var deferred = $q.defer();
		if((user.data)&&(user.data.uuid)){
			 $http.get(appSettings.baseUrl+"/user/profile?uuid="+user.data.uuid)
				 .success(function(res){
					 deferred.resolve(res);
				 })
				 
				 .error(function(res){
					 deferred.reject(res);
				 });
	 	}else{
		 deferred.reject();
	 	}
	 
	 	return deferred.promise;
  
	}
	
	/* update Profile in CRM*/
	var updateProfile = function(amount, packet, brand, johnson, other){
		var deferred = $q.defer();
		if((user.data)&&(user.data.uuid)){
			 $http.get(appSettings.baseUrl+"/user/updateprofile?method=PUT&uuid="+user.data.uuid+"&amount="+amount+"&packet="+packet+"&brand="+brand+"&JJSBF="+johnson+"&otherMember="+other)
				 .success(function(res){
					 deferred.resolve(res);
				 })
				 
				 .error(function(res){
					 deferred.reject(res);
				 });
	 	}else{
	 		deferred.reject();
	 	}
	 
	 	return deferred.promise;
  
	}
	
	var fixLater = function(){
		var deferred = $q.defer();
		  
		 if((user.data)&&(user.data.uuid)){
			 $http.get(appSettings.baseUrl+'/user/fixlater?uuid='+user.data.uuid)
			 .success(function(res){
				 deferred.resolve(res);
			 })
			 
			 .error(function(res){
				 deferred.reject(res);
			 });
			 
		 }else{
			 deferred.reject();
		 }
		 
		 return deferred.promise;
	}
  
  
  var logout = function(){ 
	  user.isAuth = false;
	  localStorage.removeItem('janrainCaptureToken');
	  localStorage.removeItem('janrainCaptureProfileData');
	  localStorage.removeItem('janrainCaptureProfileData_Expires');
	  localStorage.removeItem('janrainCaptureReturnExperienceData_Expires');
	  localStorage.removeItem('janrainCaptureToken_Expires');
	  localStorage.removeItem('connexion');
	  
  }
  

   return {
        user: user,
        setLoggedIn: setLoggedIn,
        logout: logout,
        getNextStep: getNextStep,
        getProfile: getProfile,
        updateProfile: updateProfile,
        fixLater: fixLater
   };



}]);
