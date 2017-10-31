app.directive('knob',['$timeout', function($timeout) {
    return {
        restrict: 'E',
        replace: true,
        template: '<input class="knob"  />',
        scope: {
            value: '='
        	//knobData: '=',
           // knobOptions: '&'
        },
        link: function($scope, $element) {
            
        	var knobInit = {
        			width: 115,
        	        bgColor: "#ecebeb",
        	        fgColor:"#5bd08a",
        	        thickness: .2,
        	        displayPrevious: false,
        	        readOnly:"true"
        	};

            knobInit.release = function(newValue) {
                $timeout(function() {
                    $scope.value = newValue;
                    $scope.$apply();
                });
            };

            $scope.$watch('value', function(newValue, oldValue) {
                if (newValue != oldValue) {
                    $($element).val(newValue).change();
                }
            });

            $($element).knob(knobInit);
        	
        }
    };
}]);
