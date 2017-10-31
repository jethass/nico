app.controller('planActionCtrl', ['$scope', '$rootScope', '$location', 'planService', '$http', '$q', 'appSettings', '$window', function($scope, $rootScope, $location, planService, $http, $q, appSettings, $window) {
        
	//for show loading
	$rootScope.loading=true;
	$scope.page="plan-action";
    $scope.questions = null;
    $scope.answers = {};
    $scope.code = null;
    $scope.listIds = [];
    $scope.product = null;
    $scope.fager = null;
	//for show loading
	$scope.page="plan-action";
	$scope.patientAnswers = {};
	
	planService.planAccess()
	.then(function(res){
    	if(res.success == false){
    		$rootScope.loading=true;
    		$location.path('/dashboard');
    	}
	}
	);
	
	planService.getPlan()
	 .then(function(res){
		 if(res.success == true){
			 if(res.data){
				 var questionAnswers = [];
				 $scope.questions = res.data.quiz.questions;
				 $scope.code = res.data.quiz.code;
				 $scope.product = res.data.recognizedProduct;
				 $scope.fager = res.data.scoreFager;
				 $scope.isKnownByDoctor = res.data.isKnownByDoctor;
				 if(res.data.answers){
				 	$scope.patientAnswers = res.data.answers.answers;
				 	$scope.patientAnswers.forEach(function(choice){
				 		$scope.answers[choice.question_id] = [];
				 		$scope.answers[choice.question_id].push({'id': choice.choice_id });
				 		$scope.listIds.push(choice.choice_id);
				 	});
			 	 }
				 $rootScope.loading = false;
				 
			 }else{
				 $location.path('/dashboard');
			 }
		 }else{
			 $location.path('/dashboard');
		 }
	 });
	
    var getArrayLength = function(my_object) {
        var len = 0;
        for (key in my_object) {
            len++;
        }
        return len;
    }

    $scope.submitReponses = function() {
    	
            var questionAnswers = [];
            for (key in $scope.answers) {
                for (i = 0; i < $scope.answers[key].length; i++) {
                    questionAnswers.push({'QuestionId': key, 'ChoiceId': $scope.answers[key][i].id});
                }
            };
            
            if(getArrayLength(questionAnswers) > 0){
            	planService.postPlan(questionAnswers, $scope.code)
   	       	 		.then(function(res){
   	       	 			$location.path('/dashboard');
   	       	 		});
            }
            
    }
    
    $scope.goToProduct = function() {
    	switch($scope.product) {
	        case 'Patch':
	        	$location.path('/produit-nicorette-patch');
	            break;
	        case 'Inhaleur':
	        	$location.path('/produit-nicorette-inhaleur');
	            break;
	        case 'Gommes':
	        	$location.path('/produit-nicorette-gommes');
	            break;
	        case 'Tab':
	        	$location.path('/produit-nicorette-comprimee-sucer');
	            break;
	        case 'Spray':
	        	$location.path('/produit-nicorette-spray');
	            break;
	        case 'Comprimé':
	        	$location.path('/produit-nicorette-comprimee');
	            break;    
	        default:
	        	$location.path('/dashboard');
	        	break;    
	    }
    }
    
	// check if choice answered
	$scope.isChecked = function(id){	
		if($scope.listIds.indexOf(id) != -1){
			return true;
		}else{
			return false;
		}
	}
	
	
    
    
        
}])








