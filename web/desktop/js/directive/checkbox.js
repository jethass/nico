app.directive('directiveCheckbox', function(){
	return {
		restrict: 'A',
		link: function(scope, element, attrs){
	         
			 $(element).click(function(){
		        	var divId = $(element).parent().attr('id');
		        	var input = $(element).parent().data('input');
		        	if(input == 1){
		        		 $('.input-1 .custom-checkbox').removeClass('green-bg');
			             $('.input-1  .lightcheckbox').removeClass('green');
			             $('.input-1  label.label-check').removeClass('green');
			             $('.input-1  span.txt-checkbox').removeClass('green');
			             $('.input-1  a.text-link-black').removeClass('green');
		        	}
		        	if($('#'+divId+'.custom-checkbox .lightcheckbox').is(':checked')){
		        	  $('#'+divId).addClass('green-bg');
		              $('#'+divId+'  .lightcheckbox').addClass('green');
		              $('#'+divId+'  label.label-check').addClass('green');
		              $('#'+divId+'  span.txt-checkbox').addClass('green');
		              $('#'+divId+'  a.text-link-black').addClass('green');
		              
		            }else{
		              $('#'+divId).removeClass('green-bg');
		              $('#'+divId+'  .lightcheckbox').removeClass('green');
		              $('#'+divId+'  label.label-check').removeClass('green');
		              $('#'+divId+'  span.txt-checkbox').removeClass('green');
		              $('#'+divId+'  a.text-link-black').removeClass('green');
		            }
				   
		       });
			 
			 $( document ).ready(function() {
				 var choice = attrs.choice;
				 var question = attrs.question;
				
				 if(scope.isChecked){
					 var inputchecked = scope.isChecked(parseInt(choice),parseInt(question));
					 if(inputchecked){
						 var divId = 'ck-'+question+'-'+choice;
						 $(element).trigger('click');
					 }
				 }
				});
			
		}
		
	}
	
	
})
