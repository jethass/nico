app.directive('gradiantColorSlider', function(){
	return {
		restrict: 'A',
		link: function(scope, element, attrs){
			 
	             $(element).slider({
			        range: "min",
			        value: 50,
			        min: 0,
			        max: 110,
			        step: 11,
			    });
				   
		     
		}
	}
})
