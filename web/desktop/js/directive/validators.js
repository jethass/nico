app.directive('telValidator', function() {
  var TEL_REGEXP = /^0[6-7]([-. ]?[0-9]{2}){4}$/;
 
 return {
	    require: 'ngModel',
	    restrict: 'A',
	    link: function(scope, elm, attrs, ctrl) {
	      
              elm.on('keyup', function() {
                    scope.$apply(function() {
                      ctrl.$setValidity('telValid', TEL_REGEXP.test(ctrl.$viewValue));
                    });
              });
	    }
	  };
});

app.directive('emailValidator', function() {
	  var EMAIL_REGEXP = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

	  return {
	    require: 'ngModel',
	    restrict: 'A',
	    link: function(scope, elm, attrs, ctrl) {
               elm.on('keyup', function() {
                    scope.$apply(function() {
                      ctrl.$setValidity('emailValid', EMAIL_REGEXP.test(ctrl.$viewValue));
                    });
               });
	     
	    }
	  };
});

