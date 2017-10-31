app.directive('gradiantCigarette', ['$rootScope', function ($rootScope) {
	return {
		restrict: 'A',
		link: function(scope, element, attrs){
			 scope.$watch('amount', function(){
				 if(scope.amount != undefined){
		             $(element).ionRangeSlider({
		            	    min: 0,
		            	    max: 20,
		            	    from: scope.amount,
		            	    postfix: " €",
		            	    decorate_both: false,
		            	    hide_min_max: true,
		            	    onFinish: function (data) {
		            	    	$rootScope.formAmount = data.from;
			        	    	scope.$apply();
			        	    },
		            	});
				 }
			 });
		}
	}
}]);

app.directive('gradiantJournalAfter', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'A',
        scope:true,
        link: function(scope, element, attrs) {
            scope.$watch('difficulte', function() {
                if (scope.difficulte) {
                    $(element).ionRangeSlider({
                        min: 1,
                        max: 11,
                        grid: true,
                        from: scope.difficulte,
                        //postfix: "",
                        decorate_both: false,
                        hide_min_max: true,
                        onFinish: function(data) {
                            $rootScope.finaldifficulte = data.from;
                            scope.$apply();
                        },
                    });
                }
            });
        }
        
    }
}]);




app.directive('utileSliderArreteProgramme', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'A',
        scope:true,
        link: function(scope, element, attrs) {
            scope.$watch('utile', function() {
                if (scope.utile!=undefined) {
                    $(element).ionRangeSlider({
                        min: -5,
                        max: 5,
                        grid: false,
                        from: scope.utile,
                        decorate_both: false,
                        hide_min_max: true,
                        onFinish: function(data) {
                            scope.$apply(function() {
                                $rootScope.finalutile = data.from;
                            });
                        },
                    });
                }
            });
        }
    }
}]);
app.directive('containSliderArreteProgramme', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'A',
        scope:true,
        link: function(scope, element, attrs) {
            scope.$watch('contain', function() {
                if (scope.contain) {
                    $(element).ionRangeSlider({
                        min: 0,
                        max: 10,
                        grid: false,
                        from: scope.contain,
                        decorate_both: false,
                        hide_min_max: true,
                        onFinish: function(data) {
                            scope.$apply(function() {
                                $rootScope.finalcontain = data.from;
                            });
                        },
                    });
                }
            });
        }
    }
}]);

app.directive('durationSliderArreteProgramme', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'A',
        scope:true,
        link: function(scope, element, attrs) {
            scope.$watch('duration', function() {
                if (scope.duration) {
                    $(element).ionRangeSlider({
                        min: 0,
                        max: 10,
                        grid: false,
                        from: scope.duration,
                        decorate_both: false,
                        hide_min_max: true,
                        onFinish: function(data) {
                            scope.$apply(function() {
                                $rootScope.finalduration = data.from;
                            });
                        },
                    });
                }
            });
        }
    }
}]);
app.directive('frequencySliderArreteProgramme', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'A',
        scope:true,
        link: function(scope, element, attrs) {
            scope.$watch('frequency', function() {
                if (scope.frequency) {
                    $(element).ionRangeSlider({
                        min: 0,
                        max: 10,
                        grid: false,
                        from: scope.frequency,
                        decorate_both: false,
                        hide_min_max: true,
                        onFinish: function(data) {
                            scope.$apply(function() {
                                $rootScope.finalfrequency = data.from;
                            });
                        },
                    });
                }
            });
        }
    }
}]);

app.directive('personalizationSliderArreteProgramme', ['$rootScope', function ($rootScope) {
    return {
        restrict: 'A',
        scope:true,
        link: function(scope, element, attrs) {
            scope.$watch('personalization', function() {
                if (scope.personalization) {
                    $(element).ionRangeSlider({
                        min: 0,
                        max: 10,
                        grid: false,
                        from: scope.personalization,
                        decorate_both: false,
                        hide_min_max: true,
                        onFinish: function(data) {
                            scope.$apply(function() {
                                $rootScope.finalpersonalization = data.from;
                            });
                        },
                    });
                }
            });
        }
    }
}]); 


