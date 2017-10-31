app.controller('loginCtrl', ['$scope','$rootScope','$location','$interval','authService','$http','$q','appSettings','$timeout','forgotPasswordService', function($scope,$rootScope, $location,$interval,authService,$http,$q,appSettings,$timeout,forgotPasswordService){

    if (($location.path() == '/pre-inscription')){
	 $scope.page="pre-inscription";
	}else{
		 $scope.page="login";
	}
	 $scope.person={};
	 $scope.mailSucess=false;	
	 $scope.mailError=false;
	 $scope.WsError=false;
	 $scope.uuid = null;
	 $scope.blocklogin = true;
	 $scope.blockreturn = false;
	 
	 $rootScope.intro = false;

	 if($rootScope.introClick){
		 $rootScope.intro = false;
	 }else{
		 $rootScope.introClick = false;
	 }

	 angular.element(document).ready(function () {
			$.cookieBar();
	 });
	 
	 $rootScope.hideIntro = function(){
		 $rootScope.intro = false;
		 $rootScope.introClick = true;
	 }
	 
	 function janrainCaptureWidgetOnLoad() {
		 
		 window.localStorage.removeItem('FEEDBACK_1');
       	 window.localStorage.removeItem('FEEDBACK_2');
       	 window.localStorage.removeItem('FEEDBACK_3');
         janrain.events.onCaptureLoginSuccess.addHandler(function(result) {
             janrain.capture.ui.modal.close();
             if (window.console && window.console.log) console.log(result) ;
             	authService.setLoggedIn();
	            authService.getNextStep() // Check where you want to redirect user
	                .then(
	   	             function(res){
	   	            	 console.log(res.data);
	   	            	 // success 
	   	            	 $location.path('/'+res.data);
	   	             },
	                    function(){
	   	            	 // fail
	   	            	 console.log('logging out !!');
	   	            	 authService.logout();
	   	             }
	                );
         });

         janrain.events.onCaptureSessionFound.addHandler(function(result) {
             janrain.capture.ui.modal.close();
             if (window.console && window.console.log) console.log(result);
             document.getElementById("captureSignInLink").style.display = 'none';
             document.getElementById("captureSignOutLink").style.display = '';
             document.getElementById("captureProfileLink").style.display = '';
         });

         janrain.events.onCaptureRegistrationSuccess.addHandler(function(result) {
             janrain.capture.ui.modal.close();
             if (window.console && window.console.log) console.log(result);
             document.getElementById("captureSignInLink").style.display = 'none';
             document.getElementById("captureSignOutLink").style.display = '';
             document.getElementById("captureProfileLink").style.display = '';
         });

         janrain.events.onCaptureSessionEnded.addHandler(function(result) {
             document.getElementById("captureSignInLink").style.display = '';
             document.getElementById("captureSignOutLink").style.display = 'none';
             document.getElementById("captureProfileLink").style.display = 'none';
         });

         janrain.events.onCaptureScreenShow.addHandler(function(result) {
             if (result.screen == 'returnTraditional') {
                 janrainReturnExperience();
             }
             if (result.screen == "registrationUnderage") {
                 if (!localStorage.janrainTooYoung){
                     var date = new Date();
                     var expireDate = date.setDate(date.getDate() + 1);
                     localStorage.setItem('janrainTooYoung', true);
                     localStorage.setItem('janrainTooYoung_Expires', expireDate);
                 }
             }
             if (result.screen == 'traditionalRegistration' || result.screen == 'socialRegistration') {
                 //Sample of how privacy text can be displayed next to checkbox
                 var parent = document.getElementById('capture_traditionalRegistration_form_item_inner_privacyOpt');
                 var child = document.getElementById('privacy_statement');
                 parent.appendChild(document.getElementById('privacy_statement'));
                 document.getElementById('privacy_statement').style.display=''
             }
             
         });
         
         janrain.events.onCaptureRenderComplete.addHandler(function(result) {
	        	$("#capture_signIn_traditionalSignIn_signInButton").click(function(event){
	 				event.preventDefault();
	 				
	 				if($("#condition2").is(':checked') && $("#condition3").is(':checked') ){
	 					$("#condition-error").css({'display':'none'}); 
	 					$(this).unbind('click').click();
	 				}else{
	 					alert("Vous devez accepter les conditions d'utilisations et la politique de confidentialité de Johnson & Johnson.");
	 					$("#condition-error").css({'display':'block'});
	 				}
	 			});
         	
	         	$('input[name$="traditionalSignIn_emailAddress"]').attr('placeholder','Votre Email');
		        $('input[name$="traditionalSignIn_password"]').attr('placeholder','Votre mot de passe');
		        $('input[name$="emailAddress"]').attr('placeholder','Votre Email');
		        
         	
             if (result.screen == "requirementsPostLogin") {
                 
                 if(document.getElementById("capture_requirementsPostLogin_birthdate_dateselectmonth").selectedIndex != 0){
                     document.getElementById("capture_requirementsPostLogin_form_item_birthdate").style.display="none";
                 }
             }
             
             
        });
         
         // should be the last line in janrainCaptureWidgetOnLoad()
         janrain.capture.ui.start();

     }
	 
	 janrainInterval = $interval(function(){    
		 $rootScope.loading=true;
		 if((janrain)&&(janrain.events)){
    		 janrainCaptureWidgetOnLoad();
    		 $rootScope.loading=false;
    		
    		 if($rootScope.device == 'desktop' || $rootScope.device == ''){
	         	$rootScope.intro = false;
	         }else{
	        	 $rootScope.intro = true;
				 if($rootScope.introClick)  $rootScope.intro = false;
	         }
    		 $interval.cancel(janrainInterval);
    	 }   	 
     }, 200)

}])
