app.directive('directiveAcoordion', function(){
	return {
		restrict: 'A',
		link: function(scope, element, attrs){
	         

				 $('#cssmenu > ul > li:has(ul)').addClass("has-sub");
				 
				 //$('#cssmenu > ul > li > p').click(function() {
			     $(element).click(function(){  
					 var checkElement = $(this).next();
				    
				    $('#cssmenu li').removeClass('active');
				    $(this).closest('li').addClass('active');	
				    
				    
				    if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
				      $(this).closest('li').removeClass('active');
				      checkElement.slideUp('normal');
				    }
				    
				    if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
				      $('#cssmenu ul ul:visible').slideUp('normal');
				      checkElement.slideDown('normal');
				    }
				    
				    if (checkElement.is('ul')) {
				      return false;
				    } else {
				      return true;	
				    }		
				  });

			
		}
		
	}
	
	
})
