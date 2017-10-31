app.directive('gradiantPacketCigarette', ['$rootScope', function ($rootScope) {
	return {
		restrict: 'A',
		link: function(scope, element, attrs){
			scope.$watch('packet', function(){
				if(scope.packet != undefined){
					$(element).ionRangeSlider({
		        	    min: 0,
		        	    max: 30,
		        	    from: scope.packet,
		        	    postfix: " Cigarettes",
		        	    decorate_both: false,
		        	    hide_min_max: true,
		        	    onFinish: function (data) {
		        	    	$rootScope.formPacket = data.from;
		        	    	scope.$apply();
		        	    },
		        	});
				 }
			});		 
		}
	}
}])
