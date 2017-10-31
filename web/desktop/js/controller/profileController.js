app.controller('profileCtrl', ['headerService','$scope', '$rootScope', '$location', '$interval', 'authService', '$timeout',function(headerService,$scope,$rootScope,$location,$interval,authService,$timeout){
	
	$scope.page="mon-profil";
	$scope.userName=authService.user.data.givenName;
	$scope.optins = [{"id":1,"name":"Oui"},{"id":2,"name":"Non"}];
	
	$scope.brand = false;
	$scope.johnson = false;
	$scope.other = false;
	$scope.stats = true;
	
	$scope.infosHeader = [];
	
	$rootScope.setBrandOptin = function(id){
		if(id == 1){$scope.brand=true;}else{$scope.brand=false;}
	}
	
	$scope.isBrandChecked = function(id){
		if($scope.brand){
			if(id == 1 && $scope.brand == true){
				return true
			}
		}else if(id == 2 && $scope.brand == false){
			return true;
		}else{
			return false;
		}
	}
	
	$rootScope.setJohnsonOptin = function(id){
		if(id == 1){$scope.johnson=true;}else{$scope.johnson=false;}
	}
	
	$scope.isJohnsonChecked = function(id){
		if($scope.johnson){
			if(id == 1 && $scope.johnson == true){
				return true
			}
		}else if(id == 2 && $scope.johnson == false){
			return true;
		}else{
			return false;
		}
	}
	
	$rootScope.setOtherOptin = function(id){
		if(id == 1){$scope.other=true;}else{$scope.other=false;}
	}
	
	$scope.isOtherChecked = function(id){
		if($scope.other){
			if(id == 1 && $scope.other == true){
				return true
			}
		}else if(id == 2 && $scope.other == false){
			return true;
		}else{
			return false;
		}
	}
	
	$rootScope.deconnexion=function (){
		authService.logout();
		$location.path('/login');
	};
	
	//angular.element(document).ready(function () {
		if($scope.infosHeader.length==0){
	   		headerService.initHeader()
	   		.then(function(res){
	   		    	          //console.log(res);
	   		            	  $scope.infosHeader = res;
	   		            	  //$rootScope.loading = false;
	   		      },function(res){
	   		    	         $scope.infosHeader = [];
	   		            	 alert("Une erreur s'est produite lors de connexion au web service!")
	   		      }
	   	     );		 
	   	}
		
		authService.getProfile() 
	    .then(function(res){
	        	if(res.success == true){
	        		$rootScope.profile=res.data.profile;
	        		$scope.brand = $rootScope.profile.BrandOpt;
	        		$scope.johnson = $rootScope.profile.JJSBF;
	        		$scope.other = $rootScope.profile.OtherMember;
	        		$scope.amount = $rootScope.profile.amount;
	        	    $scope.packet = $rootScope.profile.packet;
	        	    $rootScope.formPacket = $rootScope.profile.packet;
	        	    $rootScope.formAmount = $rootScope.profile.amount;
	        	}
	        },
	        function(){
	        	$rootScope.profile={};
	        }
	    );
	//});
	
	// --- page-specific settings ------------------------------------------
    janrain.settings.capture.screenToRender = 'editProfile';
    janrain.settings.providers = ['facebook','google','twitter'];
	
	function janrainCaptureWidgetOnLoad() {
        janrain.events.onCaptureAccessDenied.addHandler(function(result) {
            window.location = '/';
        });

        janrain.events.onCaptureExpiredToken.addHandler(function(result) {
            window.location = '/';
        });

        janrain.events.onCaptureSessionEnded.addHandler(function(result) {
            window.location = '/';
        });
        
        janrain.events.onCaptureProfileSaveSuccess.addHandler(function(data) {
            if (data.form == 'editProfileForm') {
            	authService.updateProfile($rootScope.formAmount, $rootScope.formPacket, $scope.brand, $scope.johnson, $scope.other) 
    		    .then(
    		        function(res){
    		        	if(res.success == true){
    		        		$rootScope.profile = res.data.profile;
                            $scope.pseudo=$rootScope.profile.displayName;
                            $("#psu").html($scope.pseudo);
    		        		console.log(res.data.msg);
    		        	}
    		        }
    		    );
            }
        });
        
      
       janrain.events.onCaptureScreenShow.addHandler(function(result) {
            
    	   if(result.screen == "changePassword"){
    		   $scope.stats = false;
                    $('#capture_changePassword_newPasswordFormProfile').submit(function (event) {
                        // Validate password
                        var PASSWD_REGEXP = /(?=^.{8,21}$)(?=(?:.*?\d){1})(?=.*[A-Z]{1})(?!.*\s)[0-9a-zA-Z!@#$%^&*()<>_-]*$/;
                        if (!PASSWD_REGEXP.test($('#capture_changePassword_newpassword').val())) {
                            $('#capture_changePassword_form_item_newpassword .capture_tip_error').html("Merci d'entrer un mot de passe valide.");
                            $('#capture_changePassword_form_item_newpassword .capture_tip_error').css("display", "block");
                            event.preventDefault();
                        } else {
                            $('#capture_changePassword_form_item_newpassword .capture_tip_error').css("display", "none");
                        }
                        // End validate password
                    });
    	   }
    	    $('#capture_editProfile_editProfileForm').submit(function(event) {
				$( "#capture_editProfile_saveButton" ).addClass( "displayBlock" );
				$( "#capture_editProfile_saveButton" ).val('Enregistrer mes mises à jour');
				$( ".capture_processing" ).addClass( "displayNone" );

				setTimeout(function() {
					$( ".capture_processing" ).addClass( "displayNone" );
				}, 100);
				setTimeout(function() {
					$( "#capture_editProfile_saveButton" ).val('Enregistrer');
				}, 1000);

                //Validation phone
				var TEL_REGEXP = /^0[1-9]([-. ]?[0-9]{2}){4}$/;
				if ($("#capture_editProfile_phone").val() == '') {
					$("#capture_editProfile_form_item_phone .capture_tip_error").html("Veuillez indiquer votre numéro de portable");
					$("#capture_editProfile_form_item_phone .capture_tip_error").css("display", "block");
					event.preventDefault();
				}else if(!TEL_REGEXP.test($('#capture_editProfile_phone').val())){
					setTimeout(function() {
						$("#capture_editProfile_form_item_phone .capture_tip_error").html("Le format est incorrect.");
						$("#capture_editProfile_form_item_phone .capture_tip_error").css("display", "block");
					}, 5);
					event.preventDefault();
				}else{
					$("#capture_editProfile_form_item_phone .capture_tip_error").css("display", "none");
				}



    	        if ( $("#capture_editProfile_displayName").val() ==null || $("#capture_editProfile_displayName").val() =="" ) {
    	           $("#capture_editProfile_form_item_displayName .capture_tip_error").html("Pseudo obligatoire.");
    	           $("#capture_editProfile_form_item_displayName .capture_tip_error").css("display","block");
  	               event.preventDefault();
    	        }else{
    	           $("#capture_editProfile_form_item_displayName .capture_tip_error").css("display","none");
    	        }
    	        
    	        var TEL_REGEXP = /^0[6-7]([-. ]?[0-9]{2}){4}$/; 
    	        if( $("#capture_editProfile_phone").val() !=null && 
    	            $("#capture_editProfile_phone").val() !="" && 
    	            !TEL_REGEXP.test($("#capture_editProfile_phone").val()) ){
    	        	$("#capture_editProfile_form_item_phone .capture_tip_error").html("Format téléphone invalide!");
     	            $("#capture_editProfile_form_item_phone .capture_tip_error").css("display","block");
    	        	event.preventDefault();
    	        }else{
    	           $("#capture_editProfile_form_item_phone .capture_tip_error").css("display","none");
    	        }
    	    });
        });
        
        janrain.events.onCaptureRenderComplete.addHandler(function(result) {
                $("#capture_editProfile_remove_photo_link").on('click',function(){
                      $timeout( function(){
                        $("#capture_editProfile_remove_photo_contain p").html("Êtes-vous sur de vouloir supprimer cette photo ?");
                        $("#capture_editProfile_confirm_remove_photo_link").html("Oui");
                        $("#capture_editProfile_cancel_remove_photo_link").html("Non"); 
                       }, 50);
                });
                       
               
        	$timeout( function(){
        		$("#capture_editProfile_displayName").attr("placeholder","Pseudo");
        		$("#capture_editProfile_email").attr("placeholder","Votre Email");
        		$("#capture_editProfile_phone").attr("placeholder","Votre téléphone");
        		$("#capture_editProfile_saveButton").val("Enregistrer");
        		$("#capture_changePassword_saveButton").val("Enregistrer");
        		
			    $("#capture_changePassword_oldpassword").attr("placeholder","Mot de passe actuel"); 
		        $("#capture_changePassword_newpassword").attr("placeholder","Nouveau mot de passe *");
		        $("#capture_changePassword_newpasswordConfirm").attr("placeholder","Confirmer *"); 
		        
			 }, 500);
        	
        	$timeout( function(){ 
        		var img=$("#capture_editProfile_photoManager_profile_pic img").attr('src');
                            if(img!=null){
                              $("#img-prof-user").attr('src',img);
                            }
                             $("#capture_editProfile_remove_photo_link").html("Supprimer");
                             $("#capture_editProfile_edit_photo_link").html("Modifier");
		             
			 }, 450);
        });

        // should be the last line in janrainCaptureWidgetOnLoad()
        $timeout( function(){ 
        	janrain.capture.ui.start();	        
		 }, 400);
    }
	
	janrainInterval = $interval(function(){    	
		 $rootScope.loading=true;
		 if((janrain)&&(janrain.events)){
			 janrainCaptureWidgetOnLoad();
	   		 $rootScope.loading=false;
	   		 $interval.cancel(janrainInterval);
 	     }   	 
  }, 200)
}])