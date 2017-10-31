app.directive('menuDashboard', function(){
	return {
		restrict: 'A',
		link: function(scope, element, attrs){
	         
			 $(element).click(function(){
				
		                var height=$(document).height();
		                if( $("ul.menuMobile > li > ul").is(':visible')){
		                        $("ul.menuMobile > li > ul").removeClass('block');
		                        $("ul.menuMobile > li a.bt-menu-mobile").removeClass('bg-white');
		                        $(".overlay").removeClass('block');
		                }else{
		                        $("ul.menuMobile > li > ul").addClass('block');
		                        $("ul.menuMobile > li a.bt-menu-mobile").addClass('bg-white');
		                        $(".overlay").addClass('block');
		                        $(".overlay").height(height);
		                }
		        
				   
		       });

			
		}
		
	}
	
	
})
