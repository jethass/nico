app.directive('directiveRadiobox', function(){
	return {
		restrict: 'A',
		link: function(scope, element, attrs){
				 scope.$watch(attrs.setFocusIf, function(value) {
						 $(element).click(function(){
				              if($(element).hasClass('active')){
					              $(element).removeClass("active");
					              $(element).addClass("disable");
					              if ($(element).is(":first-child" ) ) {
					            	  $(element).next().removeClass("disable");
					            	  $(element).next().addClass("active");
					              }else if ( $(element).is(":last-child" ) ) {
					            	  $(element).prev().removeClass("disable");
					            	  $(element).prev().addClass("active");
					              }
				              }else if($(element).hasClass('disable')){
				                  $(element).removeClass("disable");
				                  $(element).addClass("active");  
				                  if ( $(element).is( ":first-child" ) ) {
				                	  $(element).next().removeClass("active");
				                	  $(element).next().addClass("disable");
				                  }else if ( $(element).is( ":last-child" ) ) {
				                	  $(element).prev().removeClass("active");
				                	  $(element).prev().addClass("disable");
				                  }
				              }
							   
					     });
				});
		}
  }
})
