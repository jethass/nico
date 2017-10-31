app.controller('arreterCtrl', ['$scope', '$rootScope', '$location', 'authService', '$http', '$q', 'appSettings', '$window','$routeParams', function($scope, $rootScope, $location, authService, $http, $q, appSettings, $window,$routeParams) {        

	//for show loading
	//$rootScope.loading=true;
	$scope.page="arreter";
        $scope.userName=authService.user.data.givenName;
        $scope.continuer=$routeParams.continuer;
        $scope.choiceId=null;
         /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * excution en chargement de la page
         */
        angular.element(document).ready(function() {
            if($scope.continuer=='oui'){
                $scope.choiceId=2;
            }
        });


        /*
        * Author Hassine Lataoui : jethass@hotmail.com
        * vérifie si no continuer is true
        */
        $scope.continuerIsChecked=function(){
            if($scope.continuer=='oui'){
                return true;
            }else{
                return false;
            }
        }
        
       
        /*
        * Author Hassine Lataoui : jethass@hotmail.com
        * récupère checked reponse
        */
                
        $scope.setReponseCheck=function(choiceId){
                $(".custom-checkbox").removeClass('green-bg');
                $('.custom-checkbox  span.txt-checkbox').removeClass('green');
                $('.custom-checkbox  label.label-check').removeClass('green');

                $("ck-"+choiceId).addClass("green-bg");
                $("ck-"+choiceId+' span.txt-checkbox').addClass("green");
                $("ck-"+choiceId+' label.label-check').removeClass('green');
                if(choiceId=='1'){
                   $("#ck2").removeAttr('checked');
                }
                if(choiceId=='2'){
                   $("#ck1").removeAttr('checked');
                }
                $scope.choiceId=choiceId;
          }
        
        /*
        * Author Hassine Lataoui : jethass@hotmail.com
        * redirection suivant la reponse
        */
        $scope.submitReponse=function(){
            if($scope.choiceId=='1'){
              $scope.redirectToContinuer();
           }
           if($scope.choiceId=='2'){
              $scope.redirectToFelicitation();
           }
        }
        
        /*
        * Author Hassine Lataoui : jethass@hotmail.com
        * redirect to Felicitation
        */
        $scope.redirectToFelicitation = function() {
            $location.path('/arreter-felicitation');
        }
        
        /*
        * Author Hassine Lataoui : jethass@hotmail.com
        * redirect to Continuer
        */
        $scope.redirectToContinuer = function() {
            $location.path('/arreter-continuer');
        }
        
        /*
        * Author Hassine Lataoui : jethass@hotmail.com
        * redirect to MesParrains
        */
        $scope.redirectToMesParrains = function() {
            $location.path('/mes-parrains');
        }
	
	
}])