/*
 *  For dev Only
 */
function logout() {
    localStorage.removeItem('janrainCaptureToken');
    localStorage.removeItem('janrainCaptureProfileData');
    localStorage.removeItem('janrainCaptureProfileData_Expires');
    localStorage.removeItem('janrainCaptureReturnExperienceData_Expires');
    localStorage.removeItem('janrainCaptureToken_Expires');

}

var app = angular.module('nicoretteApp', ['ngRoute', 'ngResource', 'checklist-model']);

app.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {

        $locationProvider.html5Mode(true);
        $locationProvider.hashPrefix('!');

        $routeProvider
                .when('/',
                        {templateUrl: '/desktop/partials/home.html',
                            controller: 'loginCtrl',
                            requireAuth: false
                        }
                )
                .when('/pre-inscription',
                        {templateUrl: '/desktop/partials/pre-inscription.html',
                            controller: 'loginCtrl',
                            requireAuth: false
                        }
                )
                .when('/inscription',
                        {templateUrl: '/desktop/partials/inscription.html',
                            controller: 'inscriptionCtrl',
                            requireAuth: false
                        }
                )
                .when('/dashboard',
                        {templateUrl: '/desktop/partials/dashboard.html',
                            controller: 'dashboardCtrl',
                            requireAuth: true
                        }
                )
                .when('/quiz/:step',
                        {templateUrl: '/desktop/partials/quiz.html',
                            controller: 'quizCtrl',
                            requireAuth: false
                        }
                )
                .when('/mon-profil',
                        {templateUrl: '/desktop/partials/mon-profil.html',
                            controller: 'profileCtrl',
                            requireAuth: true
                        }
                )
                .when('/contrat/:type',
                        {templateUrl: '/desktop/partials/contrat.html',
                            controller: 'contratCtrl',
                            requireAuth: true
                        }
                )
                .when('/calendrier/:mois',
                        {templateUrl: '/desktop/partials/calendrier.html',
                            controller: 'calendarCtrl',
                            requireAuth: true
                        }
                )
                .when('/calendrier-list',
                        {templateUrl: '/desktop/partials/calendrier-list.html',
                            controller: 'calendarListCtrl',
                            requireAuth: true
                        }
                )
                .when('/mon-journal-before',
                        {templateUrl: '/desktop/partials/mon-journal-before.html',
                            controller: 'journalbeforeCtrl',
                            requireAuth: true
                        }
                )

                .when('/mon-journal-after',
                        {templateUrl: '/desktop/partials/mon-journal-after.html',
                            controller: 'journalafterCtrl',
                            requireAuth: true
                        }
                )

                .when('/mes-points',
                        {templateUrl: '/desktop/partials/mes-points.html',
                            controller: 'pointsCtrl',
                            requireAuth: true
                        }
                )

                .when('/mecanisme-points',
                        {templateUrl: '/desktop/partials/mecanisme-points.html',
                            controller: 'mecanismePointsCtrl',
                            requireAuth: true
                        }
                )


                .when('/plan-action',
                        {templateUrl: '/desktop/partials/plan-action.html',
                            controller: 'planActionCtrl',
                            requireAuth: true
                        }
                )

                .when('/menu-astuces',
                        {templateUrl: '/desktop/partials/menu-astuces.html',
                            controller: 'menuAstucesCtrl',
                            requireAuth: true
                        }
                )

                .when('/menu-statistiques',
                        {templateUrl: '/desktop/partials/menu-statistique.html',
                            controller: 'menuStatistiquesCtrl',
                            requireAuth: true
                        }
                )

                .when('/mes-parrains',
                        {templateUrl: '/desktop/partials/mes-parrains.html',
                            controller: 'mesParrainsCtrl',
                            requireAuth: true
                        }
                )

                .when('/produits-nicorette',
                        {templateUrl: '/desktop/partials/produits-nicorette.html',
                            controller: 'produitsNicoretteCtrl',
                            requireAuth: false
                        }
                )

                .when('/bouton-panique',
                        {templateUrl: '/desktop/partials/bouton-panique.html',
                            controller: 'boutonPaniqueCtrl',
                            requireAuth: true
                        }
                )

                .when('/panique-went-smoke',
                        {templateUrl: '/desktop/partials/bouton-panique-help.html',
                            controller: 'boutonPaniqueHelpCtrl',
                            requireAuth: true
                        }
                )

                .when('/panique-not-cracked',
                        {templateUrl: '/desktop/partials/bouton-panique-crack.html',
                            controller: 'boutonPaniqueCrackCtrl',
                            requireAuth: true
                        }
                )

                .when('/panique-cracked',
                        {templateUrl: '/desktop/partials/bouton-panique-zut.html',
                            controller: 'boutonPaniqueZutCtrl',
                            requireAuth: true
                        }
                )

                .when('/infos-legales/:bloc',
                        {templateUrl: '/desktop/partials/infos-legales.html',
                            controller: 'infosLegaleCtrl',
                            requireAuth: false
                        }
                )
                .when('/mes-alertes',
                        {templateUrl: '/desktop/partials/mes-alertes.html',
                            controller: 'mesAlertesCtrl',
                            requireAuth: false
                        }
                )

                .when('/fin-programme',
                        {templateUrl: '/desktop/partials/fin-programme.html',
                            controller: 'finProgrammeCtrl',
                            requireAuth: false
                        }
                )

                .when('/bouton-panique-mobile',
                        {templateUrl: '/desktop/partials/bouton-panique-mobile.html',
                            controller: 'boutonPaniqueMobileCtrl',
                            requireAuth: false
                        }
                )

                .when('/produit-nicorette-comprimee-sucer',
                        {templateUrl: '/desktop/partials/produit-nicorette-comprimee-sucer.html',
                            controller: 'produitComprimeeSucerCtrl',
                            requireAuth: false
                        }
                )

                .when('/produit-nicorette-comprimee',
                        {templateUrl: '/desktop/partials/produit-nicorette-comprimee.html',
                            controller: 'produitComprimeeCtrl',
                            requireAuth: false
                        }
                )

                .when('/produit-nicorette-gommes',
                        {templateUrl: '/desktop/partials/produit-nicorette-gommes.html',
                            controller: 'produitGommesCtrl',
                            requireAuth: false
                        }
                )

                .when('/produit-nicorette-inhaleur',
                        {templateUrl: '/desktop/partials/produit-nicorette-inhaleur.html',
                            controller: 'produitInhaleurCtrl',
                            requireAuth: false
                        }
                )

                .when('/produit-nicorette-patch',
                        {templateUrl: '/desktop/partials/produit-nicorette-patch.html',
                            controller: 'produitPatchCtrl',
                            requireAuth: false
                        }
                )

                .when('/produit-nicorette-spray',
                        {templateUrl: '/desktop/partials/produit-nicorette-spray.html',
                            controller: 'produitSprayCtrl',
                            requireAuth: false
                        }
                )

                .when('/introduction',
                        {templateUrl: '/desktop/partials/introduction.html',
                            controller: 'introductionCtrl',
                            requireAuth: false
                        }
                )

                .when('/contrat-date-fixe',
                        {templateUrl: '/desktop/partials/contrat-date-fixe.html',
                            controller: 'contratDateFixeCtrl',
                            requireAuth: true
                        }
                )

                .when('/arreter/:continuer',
                        {templateUrl: '/desktop/partials/mon-profil-jarrete.html',
                            controller: 'arreterCtrl',
                            requireAuth: true
                        }
                )
                .when('/arreter-felicitation',
                        {templateUrl: '/desktop/partials/mon-profil-jarrete-felicitation.html',
                            controller: 'arreterFelicitationCtrl',
                            requireAuth: true
                        }
                )
                .when('/arreter-continuer',
                        {templateUrl: '/desktop/partials/mon-profil-jarrete-continuer.html',
                            controller: 'arreterContinuerCtrl',
                            requireAuth: true
                        }
                )
                .when('/arreter-repondre',
                        {templateUrl: '/desktop/partials/mon-profil-jarrete-repondre.html',
                            controller: 'arreterRepondreCtrl',
                            requireAuth: true
                        }
                )

                .when('/mot-de-passe-oublie',
                        {templateUrl: '/desktop/partials/forget-password.html',
                            controller: 'forgetPasswordCtrl',
                            requireAuth: false
                        }
                )

                .otherwise({redirectTo: '/'});

    }])

// Manage Access
.run(['$rootScope', '$location', 'authService', '$window', 'appSettings', '$http', 'planService', function($rootScope, $location, authService, $window, appSettings, $http, planService){  
	
	/* for swiper***/
	$rootScope.doReady = function () {
		mySwiper.reInit();
    }
	$rootScope.device = localStorage.getItem('device');
	var token = localStorage.getItem('janrainCaptureToken');
	var connexion = localStorage.getItem('connexion');
	
	/*check access pages*/
	if(token){
		planService.planAccess()
			.then(function(res){
		    	if(res.success == false){
		    		console.log(res.feedbackUrl);
		    		if(res.feedbackUrl){
		    			$location.path('/'+res.feedbackUrl);
		    		}else if(res.data.fixlater == 1){
			    		if(res.data.contraturl && !connexion){
		    				$rootScope.contratUrl = res.data.contraturl;
		    				localStorage.setItem('connexion', true);
		    				if($rootScope.device == "desktop"){
		    					$("#modalPlan2").trigger("click");
		    				}else{
		    					$("#modalPlan2Mobile").trigger("click");
		    				}
			    		}
		    		}
		    	}
			}
		);
	}else{
		connexion = localStorage.removeItem('connexion');
	}
	
	//for switch journal******************/
    $rootScope.switchJournal = function() {
        var token = $window.localStorage.getItem('janrainCaptureToken');
        $http.get(appSettings.baseUrl + '/diary/switch/' + token + '?token=' + token)
                .success(function(res) {
                    console.log(res);
                    if (res.url == 'before') {
                        $location.path('/mon-journal-before');
                    } else if (res.url == 'after') {
                        $location.path('/mon-journal-after');
                    } else {
                        return false;
                    }
                })
                .error(function(res) {
                    alert('WS is Down!');
                });
    }
    
    $rootScope.accessPlan = function(){
		planService.planAccess()
	    	.then(function(res){
	        	if(res.success == false && res.data.contraturl){
	        		$rootScope.contratUrl = res.data.contraturl;
	        		$("#modalPlan").trigger("click");
	        	}else{
	        		$location.path('/plan-action');
	        	}
	    	}
	    );
	}
    
    $rootScope.accessMobilePlan = function(){
		planService.planAccess()
	    	.then(function(res){
	        	if(res.success == false && res.data.contraturl ){
	        		$rootScope.contratUrl = res.data.contraturl;
	        		$("#modalPlanMobile").trigger("click");
	        	}else{
	        		$location.path('/plan-action');
	        	}
	    	}
	    );
	}
    
    $rootScope.goContratFromDash= function(){
    	$location.path('/'+$rootScope.contratUrl);
    }
    
	/***route change **/
	$rootScope.$on('$routeChangeStart', function(evt, next, current){ 
	       if(($location.path() == '/') && (authService.user.isAuth)){
	    	   $location.path('/dashboard'); 
	       }else{
	           if(!authService.user.isAuth){
	               if(next.requireAuth){
	                     $location.path('/login');
	               }
	             } 
	       }
    })
    
    /**** reload   *****/
    $rootScope.reloadProfil = function(){
		$window.location.href = '/mon-profil'; 
	}
    
}]);

//Setup Application Configuration
app.constant('appSettings', {
    baseUrl: 'http://nicorette.proxym-it.net/app_dev.php/api'
}
);



//Setting HTTP Headers
app.config(['$httpProvider', function($httpProvider) {
        $httpProvider.interceptors.push('httpInterceptorService');
    }]);