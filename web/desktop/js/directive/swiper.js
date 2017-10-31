app.directive("swiperDirective", ["$rootScope","$timeout", function($rootScope,$timeout) {
	  return {
		    restrict: "A",
		    controller: function() {
		      this.ready = function() {
		        $rootScope.doReady();
		      }
		    },
		    link: function(scope, element, attrs) {
		    	mySwiper = new Swiper(".swiper-container", {
		            loop:true,
		            
		          });
		    }
	    
	  }
}]);

app.directive("swiperSlide", [function() {
	  return {
	    restrict: "A",
	    require: "^swiperDirective",
	    templateUrl: "/desktop/partials/usedpartials/swiper.html ",
	    link: function(scope, element, attrs, ctrl) {
	      scope.i=attrs.index;	
	      if(scope.$last) {
	            ctrl.ready();
	        }
	    }
	  }
}]);

