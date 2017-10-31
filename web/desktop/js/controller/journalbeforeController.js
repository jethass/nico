app.controller('journalbeforeCtrl', ['headerService','$scope', '$rootScope', '$location', 'authService', '$routeParams', '$http', '$q', 'appSettings', '$window', function(headerService,$scope, $rootScope, $location, authService, $routeParams, $http, $q, appSettings, $window) {

        //for show loading
        $rootScope.loading = true;

        //init params
        $scope.page = "mon-journal";
        $scope.userName = authService.user.data.givenName;
        $scope.isRenseigned = false;
        $scope.dayObjective = 0;
        $scope.questions = [];
        $scope.firstQuestion_idAnswer = 0;
        $scope.secondQuestion_idAnswer = 0;
        $scope.code = "";
        $scope.firstQuestion_idChoice = 0;
        $scope.secondQuestion_idChoice = 0;
        $scope.infosHeader = [];
        
        /*
         * Author Hassine Lataoui : jethass@hotmail.com
         * excution en chargement de la page
         */
        angular.element(document).ready(function() {
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
            $scope.beforeJournalWs().then(
                    function(res) {
                        // success 
                        console.log(res);
                        $scope.questions = res.quiz.questions;
                        $scope.dayObjective = res.dayObjective;
                        $scope.isRenseigned = res.isInsertedToday;
                        $scope.code = res.quiz.code;
                        if ($scope.isRenseigned) {
                            $("#modalrenseigned").modal();
                            $scope.isRenseigned
                            $scope.firstQuestion_idAnswer = res.lastAnswers.firstQuestion.idAnswer;
                            $scope.secondQuestion_idAnswer = res.lastAnswers.secondQuestion.idAnswer;
                            $scope.firstQuestion_idChoice = res.lastAnswers.firstQuestion.idChoice;
                            $scope.secondQuestion_idChoice = res.lastAnswers.secondQuestion.idChoice;
                        } else {

                        }
                        $rootScope.loading=false;
                    },
                    function() {
                        // fail
                         $scope.redirectToHome();
                    }
            );
        });

        /*
        * Author Hassine Lataoui : jethass@hotmail.com
        * mon journal before call WS
        */
        $scope.beforeJournalWs = function() {
            var token = $window.localStorage.getItem('janrainCaptureToken');
            var deferred = $q.defer();
            $http.get(appSettings.baseUrl + '/diary/before/' + token + '?token=' + token + '')
                    .success(function(res) {
                                if(res.success==false){
                                    var url=res.redirectUrl[0];
                                    if(url=='before'){
                                         $scope.redirectToJournalBefore();
                                    }else if(url=='after'){
                                         $scope.redirectToJournalAfter();
                                    }
                                }else{
                                    deferred.resolve(res.data);
                                }
                    })
                    .error(function(res) {
                        deferred.reject(res);
                    });
            return deferred.promise;
        };


       /*
        * Author Hassine Lataoui : jethass@hotmail.com
        * submit form
        * for Web
        */
        $scope.submitReponse = function() {
                var token = $window.localStorage.getItem('janrainCaptureToken');

                //reponse : oui de question 1 checked
                if ($("#radio72").is(':checked')) {
                        if (!$scope.isRenseigned) {
                                     var idAnswer_one = false;
                                     var idChoice_one = $("#radio72").val();
                                     var idAnswer_tow = false;                             
                                     var idChoice_tow = false;
                                     var tabParams =prepareData(idAnswer_one,idChoice_one,idAnswer_tow,idChoice_tow,$scope.code,token,'POST');        

                        } else {
                                     var idAnswer_one = $scope.firstQuestion_idAnswer;
                                     var idChoice_one = $("#radio72").val();
                                     var idAnswer_tow = $scope.secondQuestion_idAnswer;        
                                     var idChoice_tow = false;
                                     var tabParams =prepareData(idAnswer_one,idChoice_one,idAnswer_tow,idChoice_tow,$scope.code,token,'PUT');
                        }
                        WsPost($scope.code,tabParams,"modalBravo");
                }

                //reponse : non de question 1 checked
                if ($("#radio73").is(':checked')) {
                    $(".question-2.none").css("display", "block");
                }


                //reponse : l'idée d'arreter de question2 checked
                if ($("#radio74").is(':checked')) {
                        if (!$scope.isRenseigned) {
                            var idAnswer_one = false;
                            var idChoice_one = $("#radio73").val();
                            var idAnswer_tow = false;                             
                            var idChoice_tow = $("#radio74").val();
                            var tabParams =prepareData(idAnswer_one,idChoice_one,idAnswer_tow,idChoice_tow,$scope.code,token,'POST');

                        } else {
                            var idAnswer_one = $scope.firstQuestion_idAnswer;
                            var idChoice_one = $("#radio73").val();
                            var idAnswer_tow = $scope.secondQuestion_idAnswer;        
                            var idChoice_tow = $("#radio74").val();
                            var tabParams =prepareData(idAnswer_one,idChoice_one,idAnswer_tow,idChoice_tow,$scope.code,token,'PUT');
                        }
                        WsPost($scope.code,tabParams,"myModal2");
                }

                //reponse :reduire ma conexion de question2 checked
                if ($("#radio75").is(':checked')) {
                        if (!$scope.isRenseigned) {
                            var idAnswer_one = false;
                            var idChoice_one = $("#radio73").val();
                            var idAnswer_tow = false;                             
                            var idChoice_tow = $("#radio75").val();
                            var tabParams =prepareData(idAnswer_one,idChoice_one,idAnswer_tow,idChoice_tow,$scope.code,token,'POST');
                        } else {
                            var idAnswer_one = $scope.firstQuestion_idAnswer;
                            var idChoice_one = $("#radio73").val();
                            var idAnswer_tow = $scope.secondQuestion_idAnswer;        
                            var idChoice_tow = $("#radio75").val();
                            var tabParams =prepareData(idAnswer_one,idChoice_one,idAnswer_tow,idChoice_tow,$scope.code,token,'PUT');
                        }
                        WsPost($scope.code,tabParams,"myModal3");
                }

        }
        
        
        
        $scope.setReponseRadioR1=function(choiceId){
            $scope.choiceIdOne=choiceId;
        }
        
        $scope.setReponseCheckR2=function(choiceId){
           $(".custom-checkbox").removeClass('green-bg');
           $('.custom-checkbox  span.txt-checkbox').removeClass('green');
           $('.custom-checkbox  label.label-check').removeClass('green');
           
           $("ck-"+choiceId).addClass("green-bg");
           $("ck-"+choiceId+' span.txt-checkbox').addClass("green");
           $("ck-"+choiceId+' label.label-check').removeClass('green');
           
           if(choiceId=='74'){
              $("#ck75").removeAttr('checked');
           }
           if(choiceId=='75'){
              $("#ck74").removeAttr('checked');
           }
           
            $scope.choiceIdTow=choiceId;
        }
        
        /*
        * Author Hassine Lataoui : jethass@hotmail.com
        * submit form
        * for mobile
        */
        $scope.submitReponseMobile=function(){
               var token = $window.localStorage.getItem('janrainCaptureToken');
               if ($scope.choiceIdOne=='72') {
                        if (!$scope.isRenseigned) {
                                     var idAnswer_one = false;
                                     var idChoice_one = $scope.choiceIdOne;
                                     var idAnswer_tow = false;                             
                                     var idChoice_tow = false;
                                     var tabParams =prepareData(idAnswer_one,idChoice_one,idAnswer_tow,idChoice_tow,$scope.code,token,'POST');        

                        } else {
                                     var idAnswer_one = $scope.firstQuestion_idAnswer;
                                     var idChoice_one = $scope.choiceIdOne;
                                     var idAnswer_tow = $scope.secondQuestion_idAnswer;        
                                     var idChoice_tow = false;
                                     var tabParams =prepareData(idAnswer_one,idChoice_one,idAnswer_tow,idChoice_tow,$scope.code,token,'PUT');
                        }
                        WsPost($scope.code,tabParams,"modalBravo");
                }
               
               
                if ($scope.choiceIdOne=='73') {
                    $("#q1Mob").css("display", "none");
                    $("#q2Mob").css("display", "block");
                }


                
                if ($scope.choiceIdTow=='74') {
                        if (!$scope.isRenseigned) {
                            var idAnswer_one = false;
                            var idChoice_one = $scope.choiceIdOne;
                            var idAnswer_tow = false;                             
                            var idChoice_tow = $scope.choiceIdTow;
                            var tabParams =prepareData(idAnswer_one,idChoice_one,idAnswer_tow,idChoice_tow,$scope.code,token,'POST');

                        } else {
                            var idAnswer_one = $scope.firstQuestion_idAnswer;
                            var idChoice_one = $scope.choiceIdOne;
                            var idAnswer_tow = $scope.secondQuestion_idAnswer;        
                            var idChoice_tow = $scope.choiceIdTow;
                            var tabParams =prepareData(idAnswer_one,idChoice_one,idAnswer_tow,idChoice_tow,$scope.code,token,'PUT');
                        }
                        WsPost($scope.code,tabParams,"myModal2");
                }

               
                if ($scope.choiceIdTow=='75') {
                        if (!$scope.isRenseigned) {
                            var idAnswer_one = false;
                            var idChoice_one = $scope.choiceIdOne;
                            var idAnswer_tow = false;                             
                            var idChoice_tow = $scope.choiceIdTow;
                            var tabParams =prepareData(idAnswer_one,idChoice_one,idAnswer_tow,idChoice_tow,$scope.code,token,'POST');
                        } else {
                            var idAnswer_one = $scope.firstQuestion_idAnswer;
                            var idChoice_one = $scope.choiceIdOne;
                            var idAnswer_tow = $scope.secondQuestion_idAnswer;        
                            var idChoice_tow = $scope.choiceIdTow;
                            var tabParams =prepareData(idAnswer_one,idChoice_one,idAnswer_tow,idChoice_tow,$scope.code,token,'PUT');
                        }
                        WsPost($scope.code,tabParams,"myModal3");
                }
            
        }
        
        /*
        * Author Hassine Lataoui : jethass@hotmail.com
        * prepare data for ws
        */
        function prepareData(id_answer1,choice1,id_answer2,choice2,code,tokeen,method){
                           var answers = [
                                {"idAnswer": id_answer1, "idChoice": choice1},
                                {"idAnswer": id_answer2, "idChoice": choice2}
                            ];
                            var params = {
                                code: code,
                                method: method,
                                token: tokeen,
                                answers: answers
                            };
              return params;            
        }
        
        /*
        * Author Hassine Lataoui : jethass@hotmail.com
        * ws post reponse
        */
        function WsPost(code,arrayParams,modalId){
                 $http.post(appSettings.baseUrl + '/diary/answers/save/' +code+'',arrayParams)
                      .success(function(res) {
                                  console.log(res);
                                  $("#"+modalId).modal();
                      })
                      .error(function(res) {
                                  $scope.redirectToHome();
                      });
        }

       /*
        * Author Hassine Lataoui : jethass@hotmail.com
        * redirect to dashboard
        */
        $scope.redirectToDashbord = function() {
            $location.path('/dashboard');
        }

        /*
        * Author Hassine Lataoui : jethass@hotmail.com
        * redirect to Profil
        */
        $scope.redirectToProfil = function() {
            $location.path('/mon-profil');
        }
        
        
        /*
        * Author Hassine Lataoui : jethass@hotmail.com
        * redirect to Journal Before
        */
        $scope.redirectToJournalBefore = function() {
            $location.path('/mon-journal-before');
        }
        
        /*
        * Author Hassine Lataoui : jethass@hotmail.com
        * redirect to Journal after
        */
        $scope.redirectToJournalAfter = function() {
            $location.path('/mon-journal-after');
        }
        
        /*
        * Author Hassine Lataoui : jethass@hotmail.com
        * redirect to home
        */
        $scope.redirectToHome = function() {
            $location.path('/');
        }

}])








