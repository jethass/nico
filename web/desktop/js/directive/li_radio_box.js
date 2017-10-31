app.directive('directiveLiRadiobox', function(){
	return {
		restrict: 'A',
		link: function(scope, element, attrs){
	         
				 $(element).click(function(){
				        
					 	if($(element).hasClass('disable')){
		                
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
			
		}
		
	}
	
	
})
