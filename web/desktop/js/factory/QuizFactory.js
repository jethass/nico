app.factory('QuizFactory', function($http, $q,$timeout){
  var factory = {
		     quizes:false,
                    
             find: function(options){
                        var deferred = $q.defer();

						if(factory.quizes !== false) {
							deferred.resolve(factory.quizes);
						}
						else
						{
							$http.get('http://nicorette.dev.com/app_dev.php/api/quizes')
								.success(function(data, status) {
									factory.quizes = data;
									$timeout(function() {
										deferred.resolve(factory.quizes);
									}, 100)
									
								})
								.error(function(data, status) {
									deferred.reject('Impossible de recuperer les quizs')
								});
						}
			
						return deferred.promise;
             },
                    
             get: function(id){
                        var deferred = $q.defer();
                        var post={}; 
                        var posts=factory.find().then(
                                function(posts){
                                      angular.forEach(posts, function(value, key) {
                                            if (value.id == id) {
                                                    post = value;
                                            };
		                       });
                                       deferred.resolve(post);
                                    
                                },function(msg){
                                    deferred.reject(msg);
                                }
                           )
                        
                        return deferred.promise;
              },
                    
                    add: function(comment){
                        var deferred = $q.defer();
                        //ajout dans la base
                        deferred.resolve();
                        return deferred.promise;                        
                    },
                    
                    addArticle: function(article){
                        var deferred = $q.defer();
                            
                            $http.post('http://symfony-angular.dev/app_dev.php/api/articles',{'data':article})
                            .success(function(data, status, headers, config) {
                                        deferred.resolve(data);	
                            })
                            .error(function(data, status, headers, config) {
                                       deferred.reject('Impossible de sauvegarder le post')
                            });
                            
                        
                        return deferred.promise;                        
                    }
     }
     return factory;
})

